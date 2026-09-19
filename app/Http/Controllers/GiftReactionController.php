<?php

namespace App\Http\Controllers;

use App\Models\Tip;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GiftReactionController extends Controller
{
    public const REACTIONS = [
        'thanks' => ['emoji' => '❤️', 'label' => 'Thank'],
        'appreciate' => ['emoji' => '🙌', 'label' => 'Appreciate'],
        'amazing' => ['emoji' => '🔥', 'label' => 'Amazing'],
    ];

    /** Creator thanks a fan for a gift */
    public function thank(Request $request, Tip $tip): RedirectResponse
    {
        $creator = $request->user();
        abort_unless($tip->to_creator_id === $creator->id, 403);

        $reaction = $request->input('reaction', 'thanks');
        if (! array_key_exists($reaction, self::REACTIONS)) {
            $reaction = 'thanks';
        }

        if ($tip->thanked_at) {
            return back()->with('status', 'Already thanked');
        }

        $tip->forceFill([
            'thanked_at' => now(),
            'reaction' => $reaction,
        ])->save();

        $meta = self::REACTIONS[$reaction];
        $giftLabel = $tip->gift_key
            ? (\App\Support\TipCatalog::forKey($tip->gift_key)['label'] ?? 'gift')
            : 'gift';

        app(NotificationService::class)->push(
            $tip->from,
            'gift_thanks',
            $creator->displayName().' '.$meta['label'].'ed you',
            $meta['emoji'].' Thanks for your '.$giftLabel.'!',
            ['tip_id' => $tip->id, 'reaction' => $reaction]
        );

        return back()->with('status', $meta['emoji'].' Sent thanks to @'.$tip->from?->username);
    }

    /** Creator inbox of gifts they can thank */
    public function inbox(Request $request): \Illuminate\View\View
    {
        $tips = \App\Models\Tip::with('from')
            ->where('to_creator_id', $request->user()->id)
            ->latest()
            ->paginate(25);

        return view('gifts.inbox', [
            'tips' => $tips,
            'user' => $request->user(),
        ]);
    }
}
