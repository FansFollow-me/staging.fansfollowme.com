<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Subscription;
use App\Models\Tip;
use App\Models\WalletTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EarningsController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user();
        $start = now()->subDays(29)->startOfDay();

        $days = collect(range(0, 29))->map(function ($i) use ($start) {
            return $start->copy()->addDays($i)->toDateString();
        });

        $tipsByDay = Tip::where('to_creator_id', $user->id)
            ->where('created_at', '>=', $start)
            ->get()
            ->groupBy(fn ($t) => $t->created_at->toDateString())
            ->map(fn ($g) => (int) $g->sum('amount'));

        $salesByDay = Sale::where('creator_id', $user->id)
            ->where('status', 'completed')
            ->where('created_at', '>=', $start)
            ->get()
            ->groupBy(fn ($s) => $s->created_at->toDateString())
            ->map(fn ($g) => (int) $g->sum('amount'));

        $subsByDay = Subscription::where('creator_id', $user->id)
            ->where('created_at', '>=', $start)
            ->get()
            ->groupBy(fn ($s) => $s->created_at->toDateString())
            ->map(fn ($g) => (int) $g->sum('price'));

        $chart = $days->map(function ($date) use ($tipsByDay, $salesByDay, $subsByDay) {
            $tips = $tipsByDay->get($date, 0);
            $sales = $salesByDay->get($date, 0);
            $subs = $subsByDay->get($date, 0);

            return [
                'date' => $date,
                'tips' => $tips,
                'sales' => $sales,
                'subs' => $subs,
                'total' => $tips + $sales + $subs,
            ];
        })->values();

        $totals = [
            'tips' => (int) Tip::where('to_creator_id', $user->id)->sum('amount'),
            'sales' => (int) Sale::where('creator_id', $user->id)->where('status', 'completed')->sum('amount'),
            'subs' => (int) Subscription::where('creator_id', $user->id)->where('status', 'active')->sum('price'),
            'active_subs' => Subscription::where('creator_id', $user->id)->where('status', 'active')->count(),
            'balance' => $user->wallet?->balance ?? 0,
        ];

        return view('earnings.show', [
            'chart' => $chart,
            'totals' => $totals,
            'user' => $user,
        ]);
    }
}
