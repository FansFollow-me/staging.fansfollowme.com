<?php

namespace App\Http\Controllers;

use App\Models\LiveRoom;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LiveController extends Controller
{
    public function index(Request $request): View
    {
        $rooms = LiveRoom::with('creator.profile')
            ->whereIn('status', ['idle', 'live'])
            ->latest()
            ->paginate(20);

        return view('live.index', compact('rooms'));
    }

    public function show(Request $request, LiveRoom $room): View
    {
        $room->load('creator.profile');
        $canJoin = $room->canJoin($request->user());

        $recentTips = \App\Models\Tip::with('from')
            ->where('to_creator_id', $room->creator_id)
            ->latest()
            ->limit(20)
            ->get();

        return view('live.show', compact('room', 'canJoin', 'recentTips'));
    }

    public function create(): View
    {
        return view('live.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:500'],
            'mode' => ['required', 'in:public,group,one_to_one'],
            'access' => ['required', 'in:free,subscribers_only,ppv'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:500'],
            'allow_4k' => ['nullable', 'boolean'],
        ]);

        $access = $data['access'];
        $price = $access === 'ppv' ? \App\Support\Money::dollarsToCents($data['price'] ?? 0) : 0;

        if ($access === 'ppv' && $price < 100) {
            return back()
                ->withErrors(['price' => 'Paid live rooms must be at least $1.00'])
                ->withInput();
        }

        $room = LiveRoom::create([
            'creator_id' => $request->user()->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'mode' => $data['mode'],
            'access' => $access,
            'price' => $price,
            'status' => 'idle',
            'allow_4k' => $request->boolean('allow_4k', true),
            'provider' => config('app.live_provider', 'agora'),
        ]);

        return redirect()
            ->route('live.show', $room)
            ->with('status', 'Live room created (stream provider connects next)');
    }
}
