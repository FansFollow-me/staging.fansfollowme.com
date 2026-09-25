<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'avatar.image' => 'Profile photo must be an image.',
            'avatar.mimes' => 'Profile photo must be a JPG, PNG, or WebP file.',
            'avatar.max' => 'Profile photo must be 5MB or smaller.',
            'cover.image' => 'Cover image must be an image.',
            'cover.mimes' => 'Cover image must be a JPG, PNG, or WebP file.',
            'cover.max' => 'Cover image must be 5MB or smaller.',
        ]);

        $user = $request->user();
        $profile = $user->profile()->first();

        $avatarPath = $profile?->avatar_path;
        $coverPath = $profile?->cover_path;

        if ($request->boolean('remove_avatar')) {
            $this->deletePublicImage($avatarPath);
            $avatarPath = null;
        }
        if ($request->boolean('remove_cover')) {
            $this->deletePublicImage($coverPath);
            $coverPath = null;
        }

        if ($request->hasFile('avatar')) {
            $this->deletePublicImage($avatarPath);
            $avatarPath = $this->storePublicImage($request->file('avatar'));
        }
        if ($request->hasFile('cover')) {
            $this->deletePublicImage($coverPath);
            $coverPath = $this->storePublicImage($request->file('cover'));
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'display_name' => $data['display_name'],
                'bio' => $data['bio'] ?? null,
                'avatar_path' => $avatarPath,
                'cover_path' => $coverPath,
            ]
        );

        return back()->with('status', 'Profile updated');
    }

    private function storePublicImage($file): string
    {
        return \App\Support\UploadStorage::storePublic($file, 'profiles');
    }

    private function deletePublicImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        $relative = \App\Support\UploadStorage::normalize($path);
        if (str_starts_with($relative, 'profiles/')) {
            \App\Support\UploadStorage::delete($relative);
        }
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
