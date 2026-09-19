<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReferralController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $referred = User::where('referred_by', $user->id)
            ->latest()
            ->paginate(20);

        $count = User::where('referred_by', $user->id)->count();

        $code = $user->username; // simple stable code; can upgrade to hash later

        return view('referrals.index', [
            'user' => $user,
            'referred' => $referred,
            'count' => $count,
            'code' => $code,
            'signupUrl' => route('register', ['ref' => $code]),
        ]);
    }
}
