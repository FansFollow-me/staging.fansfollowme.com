<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VideoRequest;
use App\Services\NotificationService;
use App\Services\WalletService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoMessageController extends Controller
{
    public function __construct(private WalletService $wallets)
    {
    }

    /** Five fixed occasions. Brand promo uses custom price. */
    public const OCCASIONS = [
        'birthday' => 'Birthday',
        'congratulations' => 'Congratulations',
        'pep_talk' => 'Pep talk',
        'shoutout' => 'Shoutout',
        'promote_brand' => 'Promote your brand',
    ];

    /** Creator-set length/word-count tiers (cents) */
    public const TIERS = [
        1 => ['label' => 'Short · ~30 seconds', 'words' => '~40 words'],
        2 => ['label' => 'Medium · ~1 minute', 'words' => '~80 words'],
        3 => ['label' => 'Long · ~2–3 minutes', 'words' => '~160 words'],
    ];

    /** Fan requests a custom video from a creator */
    public function store(Request $request, User $creator): RedirectResponse
    {
        $fan = $request->user();

        if ($fan->id === $creator->id) {
            return back()->withErrors(['request' => 'You cannot request a video from yourself']);
        }

        if (! $creator->isCreator()) {
            return back()->withErrors(['request' => 'This user does not take video requests']);
        }

        $data = $request->validate([
            'occasion' => ['required', 'in:'.implode(',', array_keys(self::OCCASIONS))],
            'tier' => ['nullable', 'in:1,2,3'],
            'brief' => ['required', 'string', 'max:500'],
            'custom_price' => ['nullable', 'integer', 'min:500', 'max:10000000'],
            'brand_mode' => ['nullable', 'in:set_price,negotiate'],
        ]);

        $isBrand = $data['occasion'] === 'promote_brand';
        $settings = $creator->creatorSettings;

        if ($isBrand) {
            $mode = $data['brand_mode'] ?? 'set_price';
            if ($mode === 'negotiate') {
                // No charge yet — creator quotes first
                $req = VideoRequest::create([
                    'fan_id' => $fan->id,
                    'creator_id' => $creator->id,
                    'price' => 0,
                    'currency' => 'USD',
                    'occasion' => 'promote_brand',
                    'brief' => $data['brief'],
                    'status' => 'pending_quote',
                ]);

                app(NotificationService::class)->push(
                    $creator,
                    'video_request_quote',
                    'Brand promo quote request from @'.$fan->username,
                    'Reply with a price in your messages',
                    ['video_request_id' => $req->id]
                );

                return redirect()
                    ->route('video-messages.mine')
                    ->with('status', 'Quote requested — creator will send a price');
            }

            $price = (int) ($data['custom_price'] ?? 0);
            if ($price < 500) {
                return back()->withErrors(['custom_price' => 'Set a brand promo price (min $50)'])->withInput();
            }
        } else {
            $tier = (int) ($data['tier'] ?? 1);
            if (! in_array($tier, [1, 2, 3], true)) {
                $tier = 1;
            }
            $price = match ($tier) {
                2 => (int) ($settings?->video_tier2_price ?? 10000),
                3 => (int) ($settings?->video_tier3_price ?? 20000),
                default => (int) ($settings?->video_tier1_price ?? 5000),
            };
            if ($price < 100) {
                $price = 5000;
            }
            $data['tier'] = $tier;
        }

        try {
            $this->wallets->debit($fan, $price, 'video_request', 'creator', $creator->id);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['request' => 'Add funds to your wallet first']);
        }

        $this->wallets->credit($creator, $price, 'video_request_earning', 'user', $fan->id);

        $req = VideoRequest::create([
            'fan_id' => $fan->id,
            'creator_id' => $creator->id,
            'price' => $price,
            'currency' => 'USD',
            'occasion' => $data['occasion'],
            'tier' => $data['tier'] ?? null,
            'brief' => $data['brief'],
            'status' => VideoRequest::STATUS_PENDING,
        ]);

        $label = self::OCCASIONS[$data['occasion']] ?? 'Video';

        app(NotificationService::class)->push(
            $creator,
            'video_request',
            'New '.$label.' request from @'.$fan->username,
            '$'.number_format($price / 100, 2),
            ['video_request_id' => $req->id]
        );

        return redirect()
            ->route('video-messages.mine')
            ->with('status', 'Request sent — creator will record your video');
    }

    public function mine(Request $request): View
    {
        $user = $request->user();
        $requests = VideoRequest::with(['fan', 'creator'])
            ->where(function ($q) use ($user) {
                $q->where('fan_id', $user->id)
                    ->orWhere('creator_id', $user->id);
            })
            ->latest()
            ->paginate(20);

        return view('video-messages.mine', compact('requests', 'user'));
    }

    public function show(Request $request, VideoRequest $videoRequest): View
    {
        $user = $request->user();
        abort_unless(
            $videoRequest->fan_id === $user->id || $videoRequest->creator_id === $user->id,
            403
        );

        return view('video-messages.show', compact('videoRequest'));
    }

    public function complete(Request $request, VideoRequest $videoRequest): RedirectResponse
    {
        abort_unless($videoRequest->creator_id === $request->user()->id, 403);
        abort_unless(
            $videoRequest->status === VideoRequest::STATUS_PENDING
            || $videoRequest->status === VideoRequest::STATUS_ACCEPTED,
            400
        );

        $request->validate([
            'video' => ['required', 'file', 'mimes:mp4,webm,mov', 'max:204800'],
        ]);

        $path = \App\Support\UploadStorage::storePrivate($request->file('video'), 'video-messages/'.$videoRequest->id);

        $videoRequest->update([
            'video_path' => $path,
            'status' => VideoRequest::STATUS_COMPLETED,
            'completed_at' => now(),
        ]);

        app(NotificationService::class)->push(
            $videoRequest->fan,
            'video_ready',
            'Your video from '.$videoRequest->creator->displayName().' is ready',
            self::OCCASIONS[$videoRequest->occasion] ?? 'Custom video',
            ['video_request_id' => $videoRequest->id]
        );

        return redirect()
            ->route('video-messages.show', $videoRequest)
            ->with('status', 'Video delivered to fan');
    }

    public function reject(Request $request, VideoRequest $videoRequest): RedirectResponse
    {
        abort_unless($videoRequest->creator_id === $request->user()->id, 403);
        abort_unless($videoRequest->status === VideoRequest::STATUS_PENDING, 400);

        $this->wallets->credit(
            $videoRequest->fan,
            $videoRequest->price,
            'video_request_refund',
            'video_request',
            $videoRequest->id
        );

        $videoRequest->update([
            'status' => VideoRequest::STATUS_REJECTED,
            'rejected_at' => now(),
        ]);

        app(NotificationService::class)->push(
            $videoRequest->fan,
            'video_rejected',
            'Video request refunded',
            $videoRequest->creator->displayName().' declined — funds returned.',
            ['video_request_id' => $videoRequest->id]
        );

        return back()->with('status', 'Rejected — fan refunded');
    }

    public function download(Request $request, VideoRequest $videoRequest)
    {
        abort_unless(
            $videoRequest->fan_id === $request->user()->id
            || $videoRequest->creator_id === $request->user()->id,
            403
        );
        abort_unless($videoRequest->status === VideoRequest::STATUS_COMPLETED && $videoRequest->video_path, 404);

        return \App\Support\UploadStorage::response(
            $videoRequest->video_path,
            'video-message-'.$videoRequest->id.'.mp4',
            private: true
        );
    }
}
