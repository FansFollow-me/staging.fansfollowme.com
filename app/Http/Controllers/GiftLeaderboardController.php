<?php

namespace App\Http\Controllers;

use App\Models\Tip;
use App\Support\TipCatalog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GiftLeaderboardController extends Controller
{
    public function forCreator(Request $request, string $username): View
    {
        $creator = \App\Models\User::where('username', $username)
            ->where('status', 'active')
            ->firstOrFail();

        $period = $request->query('period', 'week');
        if (! in_array($period, ['week', 'month', 'all'], true)) {
            $period = 'week';
        }

        $query = Tip::query()
            ->where('to_creator_id', $creator->id)
            ->join('users as fans', 'fans.id', '=', 'tips.from_user_id')
            ->selectRaw('fans.id as fan_id, fans.username, SUM(tips.amount) as total, COUNT(*) as gift_count')
            ->groupBy('fans.id', 'fans.username')
            ->orderByDesc('total')
            ->limit(10);

        if ($period === 'week') {
            $query->where('tips.created_at', '>=', now()->startOfWeek());
        } elseif ($period === 'month') {
            $query->where('tips.created_at', '>=', now()->startOfMonth());
        }

        $rows = $query->get()->map(function ($row) {
            $row->total_display = '$'.number_format($row->total / 100, 0);

            return $row;
        });

        $medals = ['🥇', '🥈', '🥉'];

        return view('gifts.leaderboard', [
            'creator' => $creator,
            'period' => $period,
            'rows' => $rows,
            'medals' => $medals,
        ]);
    }
}
