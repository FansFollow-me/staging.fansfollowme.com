<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Sale;
use App\Models\Subscription;
use App\Models\Tip;
use App\Models\VideoRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user();
        abort_unless($user->isCreator() || $user->isAdmin(), 403);

        $creatorId = $user->id;

        // Account totals
        $totals = [
            'tips' => (int) Tip::where('to_creator_id', $creatorId)->sum('amount'),
            'ppv' => (int) \App\Models\PpvPurchase::whereHas('post', fn ($q) => $q->where('creator_id', $creatorId))->sum('amount'),
            'shop' => (int) Sale::where('creator_id', $creatorId)->where('status', 'completed')->sum('amount'),
            'video' => (int) VideoRequest::where('creator_id', $creatorId)
                ->where('status', '!=', 'pending_quote')
                ->sum('price'),
            'active_subs' => Subscription::where('creator_id', $creatorId)->where('status', 'active')
                ->where(function ($q) {
                    $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
                })->count(),
            'sub_revenue' => (int) Subscription::where('creator_id', $creatorId)->where('status', 'active')->sum('price'),
        ];

        // Per-post: views (posts table has no view count yet — use 0 placeholder column later)
        $posts = Post::where('creator_id', $creatorId)
            ->withCount(['media'])
            ->latest()
            ->limit(50)
            ->get()
            ->map(function ($post) use ($creatorId) {
                $unlocks = $post->is_paid
                    ? \App\Models\PpvPurchase::where('post_id', $post->id)->count()
                    : 0;
                $revenue = $post->is_paid
                    ? (int) \App\Models\PpvPurchase::where('post_id', $post->id)->sum('amount')
                    : 0;
                $views = $post->views_count ?? 0;
                $conv = $views > 0 ? round(($unlocks / $views) * 100, 1) : null;

                return [
                    'post' => $post,
                    'unlocks' => $unlocks,
                    'revenue' => $revenue,
                    'views' => $views,
                    'conversion' => $conv,
                ];
            });

        // Subs by week (last 8 weeks)
        $weeks = collect(range(7, 0))->map(function ($i) use ($creatorId) {
            $start = Carbon::now()->subWeeks($i)->startOfWeek();
            $end = $start->copy()->endOfWeek();
            $new = Subscription::where('creator_id', $creatorId)
                ->whereBetween('created_at', [$start, $end])
                ->count();
            $canceled = Subscription::where('creator_id', $creatorId)
                ->where('status', 'cancelled')
                ->whereBetween('cancelled_at', [$start, $end])
                ->count();

            return [
                'label' => $start->format('M j'),
                'new' => $new,
                'canceled' => $canceled,
            ];
        });

        // Top posts by revenue
        $topRevenue = $posts->sortByDesc('revenue')->take(5)->values();

        return view('analytics.show', [
            'user' => $user,
            'totals' => $totals,
            'posts' => $posts,
            'weeks' => $weeks,
            'topRevenue' => $topRevenue,
        ]);
    }
}
