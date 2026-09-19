<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function fan(Request $request): View
    {
        abort_unless($request->user()?->role === UserRole::Fan || $request->user()?->isCreator(), 403);

        return view('dashboard.fan', [
            'user' => $request->user(),
        ]);
    }

    public function creator(Request $request): View
    {
        abort_unless($request->user()?->isCreator() || $request->user()?->isAdmin(), 403);

        $user = $request->user()->load('creatorSettings', 'wallet');

        $earnings = $this->earningsFor($user->id);

        return view('dashboard.creator', [
            'user' => $user,
            'earnings' => $earnings,
        ]);
    }

    private function earningsFor(int $userId): array
    {
        $types = [
            'tip_earning' => 'Tips',
            'subscription_earning' => 'Subscriptions',
            'ppv_earning' => 'PPV',
            'shop_earning' => 'Shop',
        ];

        $wallet = \App\Models\Wallet::where('user_id', $userId)->first();

        $totals = [];
        $all = 0;
        foreach ($types as $type => $label) {
            $sum = $wallet
                ? (int) \App\Models\WalletTransaction::where('wallet_id', $wallet->id)
                    ->where('type', $type)
                    ->sum('amount')
                : 0;
            $totals[$label] = $sum;
            $all += $sum;
        }

        // Last 14 days series for sparkline/chart
        $series = [];
        if ($wallet) {
            $rows = \App\Models\WalletTransaction::where('wallet_id', $wallet->id)
                ->where('amount', '>', 0)
                ->where('type', array_keys($types))
                ->where('created_at', '>=', now()->subDays(13)->startOfDay())
                ->get(['amount', 'created_at']);

            for ($i = 13; $i >= 0; $i--) {
                $day = now()->subDays($i)->startOfDay();
                $series[] = [
                    'label' => $day->format('M j'),
                    'amount' => (int) $rows->filter(
                        fn ($r) => $r->created_at->isSameDay($day)
                    )->sum('amount'),
                ];
            }
        } else {
            for ($i = 13; $i >= 0; $i--) {
                $series[] = ['label' => now()->subDays($i)->format('M j'), 'amount' => 0];
            }
        }

        return [
            'totals' => $totals,
            'all' => $all,
            'series' => $series,
            'subscribers' => \App\Models\Subscription::where('creator_id', $userId)
                ->where('status', 'active')
                ->count(),
            'posts' => \App\Models\Post::where('creator_id', $userId)->count(),
            'products' => \App\Models\Product::where('creator_id', $userId)->count(),
        ];
    }

    public function admin(Request $request): View
    {
        abort_unless($request->user()?->isAdmin(), 403);

        return view('dashboard.admin', [
            'user' => $request->user(),
            'stats' => [
                'users' => \App\Models\User::count(),
                'creators' => \App\Models\User::where('role', UserRole::Creator)->count(),
            ],
        ]);
    }
}
