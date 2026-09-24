<?php

namespace App\Http\Controllers;

use App\Models\JoinEvent;
use App\Models\JoinLink;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JoinController extends Controller
{
    public function show(Request $request, string $code): View|RedirectResponse
    {
        $link = JoinLink::where('code', $code)
            ->where('is_active', true)
            ->with('creator.profile', 'creator.creatorSettings')
            ->firstOrFail();

        JoinEvent::create([
            'join_link_id' => $link->id,
            'type' => JoinEvent::TYPE_SCAN,
            'user_id' => Auth::id(),
            'ip_hash' => hash('sha256', $request->ip() ?? ''),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
        ]);

        // Remember creator so signup/login lands on their page
        $request->session()->put('join_creator_id', $link->creator_id);
        $request->session()->put('join_creator_username', $link->creator->username);
        $request->session()->put('join_code', $link->code);

        if (Auth::check()) {
            if ($link->follow_on_join) {
                Auth::user()->following()->syncWithoutDetaching([$link->creator_id]);
            }

            return redirect()
                ->route('profile', $link->creator->username)
                ->with('status', 'You joined via QR — follow and subscribe to get closer');
        }

        // Guests: go straight to creator profile (signup card is inline there)
        return redirect()->route('profile', $link->creator->username);
    }

    public function myQr(Request $request): View
    {
        $user = $request->user();
        abort_unless($user->isCreator() || $user->isAdmin(), 403);

        $link = JoinLink::firstOrCreate(
            ['creator_id' => $user->id],
            [
                'code' => JoinLink::generateCode(),
                'is_active' => true,
                'follow_on_join' => true,
            ]
        );

        // Ensure inactive legacy rows still render a working QR
        if (! $link->is_active) {
            $link->forceFill(['is_active' => true])->save();
        }

        $stats = [
            'scans' => $link->events()->where('type', JoinEvent::TYPE_SCAN)->count(),
            'signups' => $link->events()->where('type', JoinEvent::TYPE_SIGNUP)->count(),
        ];

        return view('join.my-qr', [
            'link' => $link,
            'stats' => $stats,
            'joinUrl' => $link->url(),
        ]);
    }
}
