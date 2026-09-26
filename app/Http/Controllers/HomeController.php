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
        $joinCode = $request->query('ref')
            ?? $request->query('join_code')
            ?? $request->session()->get('join_code');

        // Persist ref so signup/login on this profile still credits the creator
        if ($request->query('ref') || $request->query('join_code')) {
            $request->session()->put('join_code', $request->query('ref') ?? $request->query('join_code'));
            // Return the guest to this profile (with ref) after Log in / Join
            $request->session()->put('join_creator_username', $user->username);
        }

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

        // Count a scan when the share URL (profile?ref=…) is opened (skip /j/ double-count)
        if ($joinLink && $request->query('ref') && $request->session()->get('qr_scan_for') !== $joinLink->code) {
            $request->session()->put('qr_scan_for', $joinLink->code);
            \App\Models\JoinEvent::create([
                'join_link_id' => $joinLink->id,
                'type' => \App\Models\JoinEvent::TYPE_SCAN,
                'user_id' => auth()->id(),
                'ip_hash' => hash('sha256', $request->ip() ?? ''),
                'user_agent' => substr((string) $request->userAgent(), 0, 255),
            ]);
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

        $refCode = $joinLink?->code;
        $loginUrl = route('login', array_filter(['ref' => $refCode]));
        $signupUrl = route('register', array_filter(['ref' => $refCode]));

        return view('profiles.show', [
            'loginUrl' => $loginUrl,
            'signupUrl' => $signupUrl,
            'refCode' => $refCode,
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
