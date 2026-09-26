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
            'user' => $request->user()->load(['profile', 'creatorSettings']),
        ]);
    }

    public function updatePage(Request $request)
    {
        // Surface silent PHP upload failures (post_max_size / upload_max_filesize)
        // instead of reporting success and leaving the old image in place.
        foreach (['avatar' => 'Profile photo', 'cover' => 'Cover image'] as $field => $label) {
            $file = $request->file($field);
            if (\App\Support\ImageUpload::hasFailedUpload($file)) {
                return back()
                    ->withErrors([$field => \App\Support\ImageUpload::uploadErrorMessage($file)])
                    ->withInput();
            }
        }

        $data = $request->validate([
            'display_name' => ['required', 'string', 'max:80'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,heic,heif', 'max:20480'],
            'cover' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,heic,heif', 'max:20480'],
        ], [
            'avatar.mimes' => 'Profile photo must be a JPG, PNG, WebP, or HEIC file.',
            'avatar.max' => 'Profile photo must be 20MB or smaller.',
            'cover.mimes' => 'Cover image must be a JPG, PNG, WebP, or HEIC file.',
            'cover.max' => 'Cover image must be 20MB or smaller.',
        ]);

        $user = $request->user();
        $profile = $user->profile()->first();

        $avatarPath = $profile?->avatar_path;
        $coverPath = $profile?->cover_path;

        try {
            if ($request->boolean('remove_avatar')) {
                $this->deletePublicImage($avatarPath);
                $avatarPath = null;
            }
            if ($request->boolean('remove_cover')) {
                $this->deletePublicImage($coverPath);
                $coverPath = null;
            }

            if ($request->hasFile('avatar')) {
                $newAvatar = $this->storePublicImage($request->file('avatar'), \App\Support\ImageUpload::KIND_AVATAR);
                $this->deletePublicImage($avatarPath);
                $avatarPath = $newAvatar;
            }
            if ($request->hasFile('cover')) {
                $newCover = $this->storePublicImage($request->file('cover'), \App\Support\ImageUpload::KIND_COVER);
                $this->deletePublicImage($coverPath);
                $coverPath = $newCover;
            }
        } catch (\Throwable $e) {
            return back()
                ->withErrors(['avatar' => 'Image upload failed: '.$e->getMessage()])
                ->withInput();
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

        // Subscription price (creators / admins). Stored in cents.
        // Active subscription rows keep their price until renewal.
        if ($user->isCreator() || $user->isAdmin()) {
            $subData = $request->validate([
                'subscription_free' => ['nullable', 'boolean'],
                'subscription_price' => ['nullable', 'numeric', 'min:0', 'max:100'],
            ], [
                'subscription_price.min' => 'Subscription price must be at least $1.00.',
                'subscription_price.max' => 'Subscription price cannot exceed $100.00.',
            ]);

            if ($request->boolean('subscription_free')) {
                $priceCents = 0;
            } else {
                $priceCents = \App\Support\Money::dollarsToCents($subData['subscription_price'] ?? 0);
                if ($priceCents < 100 || $priceCents > 10000) {
                    return back()
                        ->withErrors(['subscription_price' => 'Subscription price must be between $1.00 and $100.00 (or turn on Free).'])
                        ->withInput();
                }
            }

            $user->creatorSettings()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'subscription_price' => $priceCents,
                    'currency' => 'USD',
                    'accepts_subscriptions' => $priceCents > 0,
                ]
            );
        }

        return back()->with('status', 'Profile updated');
    }

    private function storePublicImage($file, string $kind = 'avatar'): string
    {
        return \App\Support\ImageUpload::store($file, 'profiles', $kind, 'public');
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
            'video_tier1_price' => ['required', 'numeric', 'min:1', 'max:500'],
            'video_tier2_price' => ['required', 'numeric', 'min:1', 'max:500'],
            'video_tier3_price' => ['required', 'numeric', 'min:1', 'max:500'],
            'video_messages_enabled' => ['nullable', 'boolean'],
            'brand_promo_enabled' => ['nullable', 'boolean'],
        ]);

        $user->creatorSettings()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'video_tier1_price' => \App\Support\Money::dollarsToCents($data['video_tier1_price']),
                'video_tier2_price' => \App\Support\Money::dollarsToCents($data['video_tier2_price']),
                'video_tier3_price' => \App\Support\Money::dollarsToCents($data['video_tier3_price']),
                'video_messages_enabled' => $request->boolean('video_messages_enabled', true),
                'brand_promo_enabled' => $request->boolean('brand_promo_enabled', true),
            ]
        );

        return back()->with('status', 'Video pricing saved');
    }
}
