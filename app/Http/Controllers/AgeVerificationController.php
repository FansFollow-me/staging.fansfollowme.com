<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgeVerificationController extends Controller
{
    public function show(Request $request): View
    {
        return view('age-verification.show', [
            'user' => $request->user(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'confirm_age' => ['accepted'],
            'method' => ['required', 'in:self_declare,yoti,didit'],
        ]);

        // Shell: self-declare only until Yoti/Didit keys ship
        if ($data['method'] !== 'self_declare') {
            return back()->withErrors(['method' => 'Third-party age check needs API keys']);
        }

        // age_confirmed_at = signup checkbox; age_verified_at = this explicit step (or Yoti/Didit later)
        $request->user()->forceFill([
            'age_verified_at' => now(),
            'age_verification_method' => $data['method'],
        ])->save();

        return redirect()
            ->route('dashboard')
            ->with('status', 'Age verified (self-declare). Third-party verify comes with provider keys.');
    }
}
