<?php

namespace App\Http\Controllers;

use App\Models\Reel;
use App\Models\Story;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReelController extends Controller
{
    public function index(Request $request): View
    {
        $reels = Reel::with('creator.profile')
            ->where('status', 'published')
            ->latest()
            ->paginate(24);

        return view('reels.index', compact('reels'));
    }

    public function create(): View
    {
        return view('reels.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'caption' => ['nullable', 'string', 'max:500'],
            'video' => ['required', 'file', 'mimes:mp4,webm,mov', 'max:102400'],
            'thumbnail' => ['nullable', 'image', 'max:5120'],
        ]);

        $videoPath = \App\Support\UploadStorage::storePublic($request->file('video'), 'reels');
        $thumbPath = $request->hasFile('thumbnail')
            ? \App\Support\UploadStorage::storePublic($request->file('thumbnail'), 'reels/thumbs')
            : null;

        Reel::create([
            'creator_id' => $request->user()->id,
            'caption' => $data['caption'] ?? null,
            'video_path' => $videoPath,
            'thumbnail_path' => $thumbPath,
            'status' => 'published',
        ]);

        return redirect()->route('reels.index')->with('status', 'Reel published');
    }

    public function show(Reel $reel): View
    {
        if ($reel->status !== 'published' && $reel->creator_id !== auth()->id()) {
            abort(404);
        }

        $reel->increment('views');

        return view('reels.show', ['reel' => $reel->load('creator')]);
    }

    public function mine(Request $request): View
    {
        $reels = Reel::where('creator_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return view('reels.mine', compact('reels'));
    }
}
