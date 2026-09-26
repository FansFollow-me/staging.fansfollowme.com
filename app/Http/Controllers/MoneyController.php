<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PpvPurchase;
use App\Models\Subscription;
use App\Models\Tip;
use App\Models\User;
use App\Services\WalletService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MoneyController extends Controller
{
    public function __construct(private WalletService $wallets)
    {
    }

    public function follow(Request $request, User $creator): RedirectResponse
    {
        $user = $request->user();

        if ($user->id === $creator->id) {
            return back()->withErrors(['follow' => 'You cannot follow yourself']);
        }

        $user->following()->syncWithoutDetaching([$creator->id]);

        app(\App\Services\NotificationService::class)->push(
            $creator,
            'follow',
            '@'.$user->username.' started following you'
        );

        return back()->with('status', 'Following @'.$creator->username);
    }

    public function unfollow(Request $request, User $creator): RedirectResponse
    {
        $request->user()->following()->detach($creator->id);

        return back()->with('status', 'Unfollowed @'.$creator->username);
    }

    public function subscribe(Request $request, User $creator): RedirectResponse
    {
        $user = $request->user();

        if ($user->id === $creator->id) {
            return back()->withErrors(['subscribe' => 'You cannot subscribe to yourself']);
        }

        $price = (int) ($creator->creatorSettings?->subscription_price ?? 0);

        if ($price <= 0) {
            return back()->withErrors(['subscribe' => 'Creator has no subscription price set']);
        }

        try {
            $this->wallets->debit($user, $price, 'subscription', 'creator', $creator->id);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['subscribe' => 'Add funds to your wallet first']);
        }
        $this->wallets->credit($creator, $price, 'subscription_earning', 'creator', $user->id);

        Subscription::updateOrCreate(
            ['fan_id' => $user->id, 'creator_id' => $creator->id],
            [
                'status' => 'active',
                'price' => $price,
                'currency' => 'USD',
                'provider' => 'wallet',
                'started_at' => now(),
                'ends_at' => now()->addMonth(),
                'cancelled_at' => null,
            ]
        );

        app(\App\Services\NotificationService::class)->push(
            $creator,
            'subscribe',
            'New subscriber @'.$user->username,
            '$'.number_format($price / 100, 2).'/mo',
            ['from' => $user->username]
        );

        $user->following()->syncWithoutDetaching([$creator->id]);

        return back()->with('status', 'Subscribed to @'.$creator->username);
    }

    public function cancelSubscription(Request $request, User $creator): RedirectResponse
    {
        Subscription::where('fan_id', $request->user()->id)
            ->where('creator_id', $creator->id)
            ->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'ends_at' => now(),
            ]);

        return back()->with('status', 'Subscription cancelled');
    }

    public function tip(Request $request, User $creator): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['nullable', 'integer', 'min:1', 'max:1000000'],
            'message' => ['nullable', 'string', 'max:200'],
            'gift_key' => ['nullable', 'string', 'max:40'],
            'post_id' => ['nullable', 'integer', 'exists:posts,id'],
        ]);

        $user = $request->user();
        $gift = ! empty($data['gift_key'])
            ? \App\Support\TipCatalog::forKey($data['gift_key'])
            : null;

        if (! empty($data['gift_key']) && ! $gift) {
            return back()->withErrors(['gift_key' => 'Unknown gift'])->withInput();
        }

        if ($gift) {
            $amount = (int) $gift['amount'];
        } else {
            $amount = (int) ($data['amount'] ?? 0);
            if ($amount < 100) {
                return back()->withErrors(['amount' => 'Minimum tip is $1.00'])->withInput();
            }
        }

        try {
            $this->wallets->debit($user, $amount, 'tip', 'creator', $creator->id);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['tip' => 'Add funds to your wallet first']);
        }
        $this->wallets->credit($creator, $amount, 'tip_earning', 'user', $user->id);

        $giftKey = $gift['key'] ?? null;
        $giftLabel = $gift['label'] ?? null;

        Tip::create([
            'from_user_id' => $user->id,
            'to_creator_id' => $creator->id,
            'post_id' => $data['post_id'] ?? null,
            'amount' => $amount,
            'currency' => 'USD',
            'message' => $data['message'] ?? ($giftLabel ? $giftLabel.' sent!' : null),
            'gift_key' => $giftKey,
            'provider' => 'wallet',
        ]);

        app(\App\Services\NotificationService::class)->push(
            $creator,
            'tip',
            ($giftLabel ?: 'Tip').' from @'.$user->username,
            '$'.number_format($amount / 100, 2),
            ['from' => $user->username]
        );

        $status = $giftLabel
            ? $giftLabel.' sent to @'.$creator->username.'!'
            : 'Tip sent to @'.$creator->username;

        return redirect()
            ->back()
            ->with('status', $status)
            ->with('gift_flash', $giftKey)
            ->with('gift_from', $user->username)
            ->with('gift_tier', $gift ? ($gift['tier'] ?? 1) : 1);
    }

    public function unlockPost(Request $request, Post $post): RedirectResponse
    {
        $user = $request->user();

        if (! $post->isPpv()) {
            return back();
        }

        if (! $post->isLockedFor($user)) {
            return back()->with('status', 'Already unlocked');
        }

        $amount = max(0, (int) $post->price);

        try {
            $this->wallets->debit($user, $amount, 'ppv', 'post', $post->id);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['unlock' => 'Add funds to your wallet first']);
        }
        $this->wallets->credit($post->creator, $amount, 'ppv_earning', 'post', $post->id);

        PpvPurchase::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'amount' => $amount,
            'currency' => 'USD',
            'provider' => 'wallet',
        ]);

        return redirect()
            ->route('posts.show', $post)
            ->with('status', 'Post unlocked');
    }

    public function addFunds(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:100000'],
        ]);

        $amount = \App\Support\Money::dollarsToCents($data['amount']);
        $stripe = app(\App\Services\StripeService::class);

        if (! $stripe->enabled()) {
            return back()->withErrors(['amount' => 'Card payments are not configured yet']);
        }

        try {
            $url = $stripe->createWalletCheckout(
                $request->user()->id,
                $amount,
                route('wallet.stripe-return').'?session_id={CHECKOUT_SESSION_ID}',
                route('wallet.show')
            );
        } catch (\Throwable $e) {
            return back()->withErrors(['amount' => $e->getMessage()]);
        }

        return redirect()->away($url);
    }

    public function stripeReturn(Request $request): RedirectResponse
    {
        return redirect()
            ->route('wallet.show')
            ->with('status', 'Payment received — balance updates in a few seconds');
    }

    public function wallet(Request $request): View
    {
        $user = $request->user()->load('wallet');

        $transactions = \App\Models\WalletTransaction::whereHas('wallet', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->latest()->paginate(20);

        return view('wallet.show', [
            'user' => $user,
            'transactions' => $transactions,
        ]);
    }
}
