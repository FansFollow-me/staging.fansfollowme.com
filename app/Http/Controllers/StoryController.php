<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoryController extends Controller
{
    public function index(Request $request): View
    {
        $stories = Story::with('creator.profile')
            ->where(function ($q) {
                $q->where('expires_at', '>', now())
                    ->orWhereNull('expires_at');
            })
            ->latest()
            ->get()
            ->groupBy('creator_id');

        return view('stories.index', compact('stories'));
    }

    public function create(): View
    {
        return view('stories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'type' => ['required', 'in:media,text'],
            'body' => ['nullable', 'string', 'max:500'],
            'media' => ['nullable', 'file', 'image,video', 'max:51200'],
        ]);

        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = \App\Support\UploadStorage::storePublic($request->file('media'), 'stories');
        }

        Story::create([
            'creator_id' => $request->user()->id,
            'type' => $data['type'],
            'body' => $data['body'] ?? null,
            'media_path' => $mediaPath,
            'expires_at' => now()->addHours(24),
        ]);

        return redirect()->route('stories.index')->with('status', 'Story posted');
    }

    public function show(Story $story): View
    {
        if ($story->isExpired()) {
            abort(404);
        }

        return view('stories.show', ['story' => $story->load('creator')]);
    }
}
