<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function page(Request $request): View
    {
        return view('dashboard.settings-page', [
            'user' => $request->user()->load('profile'),
        ]);
    }

    public function updatePage(Request $request)
    {
        $data = $request->validate([
            'display_name' => ['required', 'string', 'max:80'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        $request->user()->profile()->updateOrCreate(
            ['user_id' => $request->user()->id],
            $data
        );

        return back()->with('status', 'Profile updated');
    }

    /** Creator video-message pricing (3 tiers + brand toggle) */
    public function videoPricing(Request $request): View
    {
        $user = $request->user();
        abort_unless($user->isCreator() || $user->isAdmin(), 403);

        return view('dashboard.video-pricing', [
            'user' => $user->load('creatorSettings'),
            'tiers' => \App\Http\Controllers\VideoMessageController::TIERS,
        ]);
    }

    public function updateVideoPricing(Request $request)
    {
        $user = $request->user();
        abort_unless($user->isCreator() || $user->isAdmin(), 403);

        $data = $request->validate([
            'video_tier1_price' => ['required', 'numeric', 'min:1', 'max:100000'],
            'video_tier2_price' => ['required', 'numeric', 'min:1', 'max:100000'],
            'video_tier3_price' => ['required', 'numeric', 'min:1', 'max:100000'],
            'video_messages_enabled' => ['nullable', 'boolean'],
            'brand_promo_enabled' => ['nullable', 'boolean'],
        ]);

        $user->creatorSettings()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'video_tier1_price' => (int) $data['video_tier1_price'] * 100,
                'video_tier2_price' => (int) $data['video_tier2_price'] * 100,
                'video_tier3_price' => (int) $data['video_tier3_price'] * 100,
                'video_messages_enabled' => $request->boolean('video_messages_enabled', true),
                'brand_promo_enabled' => $request->boolean('brand_promo_enabled', true),
            ]
        );

        return back()->with('status', 'Video pricing saved');
    }
}
