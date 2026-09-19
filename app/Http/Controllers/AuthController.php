<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\CreatorSetting;
use App\Models\JoinEvent;
use App\Models\JoinLink;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Wallet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('marketing.login-exact');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username_email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = strtolower($request->input('username_email')).'|'.$request->ip();

        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'username_email' => __('Too many login attempts. Try again in :seconds seconds.', ['seconds' => $seconds]),
            ]);
        }

        $identity = $credentials['username_email'];
        $user = User::where('email', $identity)
            ->orWhere('username', $identity)
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'username_email' => __('Invalid credentials'),
            ]);
        }

        if ($user->status !== 'active') {
            throw ValidationException::withMessages([
                'username_email' => __('This account is not active'),
            ]);
        }

        \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);
        Auth::login($user, $request->boolean('remember'));
        $joinUsername = $request->session()->get('join_creator_username');
        $request->session()->regenerate();

        if ($joinUsername) {
            return redirect()
                ->route('profile', $joinUsername)
                ->with('status', 'Welcome back — subscribe to get closer');
        }

        return redirect()->intended($this->homeFor($user));
    }

    public function showRegister(Request $request): View
    {
        if ($request->query('join_code')) {
            $request->session()->flash('join_code', $request->query('join_code'));
        }

        return view('marketing.signup-exact');
    }

    public function register(Request $request): RedirectResponse
    {
        // Mockup field names: name, username, email, password, role, terms
        if (! $request->filled('password_confirmation')) {
            $request->merge(['password_confirmation' => $request->input('password')]);
        }
        if ($request->filled('role_type') && ! $request->filled('role')) {
            $request->merge(['role' => $request->input('role_type')]);
        }

        $data = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:30', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:fan,creator'],
            'terms' => ['accepted'],
            'name' => ['nullable', 'string', 'max:80'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'age_confirm' => ['accepted'],
        ]);

        $dob = \Carbon\Carbon::parse($data['date_of_birth']);
        if ($dob->age < 18) {
            return back()
                ->withErrors(['date_of_birth' => 'You must be 18 or older to join FansFollow.me'])
                ->withInput();
        }

        $joinCode = $request->session()->get('join_code')
            ?? $request->input('join_code')
            ?? $request->input('ref');

        if ($joinCode) {
            // Prefer QR code table; fall back to username as referral code
            $link = JoinLink::where('code', $joinCode)->where('is_active', true)->first();
            if (! $link) {
                $refUser = User::where('username', $joinCode)->first();
                if ($refUser) {
                    $request->merge(['_referred_by' => $refUser->id]);
                }
            }
        }

        $user = DB::transaction(function () use ($data, $joinCode, $request) {
            $referredBy = null;
            $joinLink = null;

            if ($joinCode) {
                $joinLink = JoinLink::where('code', $joinCode)
                    ->where('is_active', true)
                    ->first();

                if ($joinLink) {
                    $referredBy = $joinLink->creator_id;
                } elseif ($request->input('_referred_by')) {
                    $referredBy = (int) $request->input('_referred_by');
                }
            }

            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => UserRole::from($data['role']),
                'status' => 'active',
                'referred_by' => $referredBy,
                'date_of_birth' => $data['date_of_birth'],
                'age_confirmed_at' => now(),
                'age_confirmation_ip' => $request->ip(),
            ]);

            UserProfile::create([
                'user_id' => $user->id,
                'display_name' => $data['name'] ?? $data['username'],
            ]);

            Wallet::create([
                'user_id' => $user->id,
                'balance' => 0,
                'currency' => 'USD',
            ]);

            if ($user->isCreator()) {
                CreatorSetting::create([
                    'user_id' => $user->id,
                    'subscription_price' => 999,
                    'currency' => 'USD',
                    'accepts_subscriptions' => true,
                ]);

                JoinLink::create([
                    'creator_id' => $user->id,
                    'code' => JoinLink::generateCode(),
                    'is_active' => true,
                    'follow_on_join' => true,
                ]);
            }

            if ($joinLink) {
                JoinEvent::create([
                    'join_link_id' => $joinLink->id,
                    'type' => JoinEvent::TYPE_SIGNUP,
                    'user_id' => $user->id,
                    'ip_hash' => hash('sha256', $request->ip() ?? ''),
                ]);

                if ($joinLink->follow_on_join) {
                    DB::table('follows')->insert([
                        'follower_id' => $user->id,
                        'creator_id' => $joinLink->creator_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            return $user;
        });

        Auth::login($user);
        $joinUsername = $request->session()->get('join_creator_username');
        $request->session()->forget(['join_code']);
        $request->session()->regenerate();

        if ($joinUsername) {
            return redirect()
                ->route('profile', $joinUsername)
                ->with('status', 'Account ready — subscribe to unlock full access');
        }

        return redirect()->intended($this->homeFor($user));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function homeFor(User $user): string
    {
        return match ($user->role) {
            UserRole::Admin => route('admin.dashboard'),
            UserRole::Creator => route('creator.dashboard'),
            default => route('dashboard'),
        };
    }
}
