<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

/**
 * Password reset without SMTP — token stored in session for demo.
 * Swap to Laravel notifications when mail keys exist.
 */
class PasswordResetController extends Controller
{
    public function showRequest(): View
    {
        return view('auth.password-request');
    }

    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $data['email'])->first();

        // Always flash success (no user enumeration)
        if ($user) {
            $token = Str::random(64);
            session(['password_reset_token' => $token, 'password_reset_user' => $user->id]);
            // Demo: show token on next screen (in prod this is emailed)
            return redirect()
                ->route('password.reset.form')
                ->with('demo_token', $token);
        }

        return redirect()
            ->route('password.reset.form')
            ->with('status', 'If that email exists, a reset token was issued.');
    }

    public function showReset(): View
    {
        return view('auth.password-reset', [
            'demoToken' => session('demo_token'),
        ]);
    }

    public function reset(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if ($data['token'] !== session('password_reset_token')) {
            return back()->withErrors(['token' => 'Invalid or expired reset token'])->withInput();
        }

        $user = User::where('email', $data['email'])
            ->whereKey(session('password_reset_user'))
            ->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Invalid reset request'])->withInput();
        }

        $user->forceFill(['password' => Hash::make($data['password'])])->save();
        session()->forget(['password_reset_token', 'password_reset_user', 'demo_token']);

        return redirect()
            ->route('login')
            ->with('status', 'Password updated — log in');
    }
}
