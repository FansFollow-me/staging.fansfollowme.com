<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Pixel-exact port of the Bolt mockup homepage
        return view('marketing.home-exact');
    }

    public function page(Request $request, string $name): View
    {
        $allowed = [
            'explore', 'creators', 'fans', 'celebrities', 'casting',
            'business', 'for-creators', 'support', 'faq', 'contact',
            'blog', 'privacy', 'terms', 'cookies', 'live-streams', 'revenue-streams',
            'qr-signups',
        ];

        abort_unless(in_array($name, $allowed, true), 404);

        // Logged-in users get the live product explore (real creators + posts)
        if ($name === 'explore' && $request->user()) {
            return $this->liveExplore($request);
        }

        // Pixel-exact ports for marketing / guests
        $exact = [
            'explore' => 'marketing.explore-exact',
            'for-creators' => 'marketing.for-creators-exact',
            'fans' => 'marketing.fans-exact',
            'celebrities' => 'marketing.celebrities-exact',
            'casting' => 'marketing.casting-exact',
            'business' => 'marketing.business-exact',
            'live-streams' => 'marketing.live-streams-exact',
            'support' => 'marketing.support-exact',
            'faq' => 'marketing.faq-exact',
            'contact' => 'marketing.contact-exact',
            'blog' => 'marketing.blog-exact',
            'privacy' => 'marketing.privacy-exact',
            'terms' => 'marketing.terms-exact',
            'cookies' => 'marketing.cookies-exact',
            'creators' => 'marketing.creators-exact',
            'revenue-streams' => 'marketing.revenue-streams-exact',
            'qr-signups' => 'marketing.qr-signups-exact',
        ];

        if (isset($exact[$name]) && view()->exists($exact[$name])) {
            return view($exact[$name]);
        }

        return view('pages.'.$name);
    }

    private function liveExplore(Request $request): View
    {
        $creators = User::with(['profile', 'creatorSettings'])
            ->where('role', \App\Enums\UserRole::Creator)
            ->where('status', 'active')
            ->orderBy('username')
            ->paginate(24);

        $posts = \App\Models\Post::with('creator.profile')
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(12);

        return view('explore.live', compact('creators', 'posts'));
    }

    public function profile(Request $request, string $username): View
    {
        $user = User::where('username', $username)
            ->where('status', 'active')
            ->with(['profile', 'creatorSettings'])
            ->firstOrFail();

        $recentTips = \App\Models\Tip::with('from')
            ->where('to_creator_id', $user->id)
            ->latest()
            ->limit(8)
            ->get();

        $giftTotals = \App\Models\Tip::where('to_creator_id', $user->id)
            ->whereNotNull('gift_key')
            ->get(['gift_key', 'amount'])
            ->groupBy('gift_key')
            ->map(fn ($g) => ['count' => $g->count(), 'amount' => (int) $g->sum('amount')]);

        // QR / referral context for inline guest signup
        $joinCode = $request->session()->get('join_code')
            ?? $request->query('join_code')
            ?? $request->query('ref');

        $joinLink = null;
        if ($joinCode) {
            $joinLink = \App\Models\JoinLink::where('code', $joinCode)
                ->where('is_active', true)
                ->where('creator_id', $user->id)
                ->first();
        }
        if (! $joinLink && $user->isCreator()) {
            $joinLink = \App\Models\JoinLink::where('creator_id', $user->id)
                ->where('is_active', true)
                ->first();
        }

        $isSubscribed = false;
        if (auth()->check() && auth()->id() !== $user->id) {
            $isSubscribed = \App\Models\Subscription::where('fan_id', auth()->id())
                ->where('creator_id', $user->id)
                ->where('status', 'active')
                ->where(function ($q) {
                    $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
                })
                ->exists();
        }

        $shareJoinLink = $joinLink;
        if (! $shareJoinLink && $user->isCreator()) {
            $shareJoinLink = \App\Models\JoinLink::where('creator_id', $user->id)
                ->where('is_active', true)
                ->first();
        }

        return view('profiles.show', [
            'profileUser' => $user,
            'posts' => $user->posts()
                ->with('media')
                ->where('status', 'published')
                ->latest('published_at')
                ->paginate(12),
            'recentTips' => $recentTips,
            'giftTotals' => $giftTotals,
            'joinLink' => $joinLink,
            'shareJoinUrl' => $shareJoinLink?->url(),
            'isSubscribed' => $isSubscribed,
            'followerCount' => $user->followers()->count(),
            'postCount' => $user->posts()->where('status', 'published')->count(),
        ]);
    }
}
