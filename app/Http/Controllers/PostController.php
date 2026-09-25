<?php

namespace App\Http\Controllers;

use App\Enums\PostType;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $posts = Post::with('media')
            ->where('creator_id', $user->id)
            ->latest()
            ->paginate(20);

        return view('posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
            'type' => ['required', 'in:text,photo,video,audio,reel'],
            'is_paid' => ['nullable', 'boolean'],
            'price' => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'media' => ['nullable', 'file', 'max:51200'],
        ]);

        $isPaid = $request->boolean('is_paid');
        $price = $isPaid ? (int) ($data['price'] ?? 0) : 0;

        if ($isPaid && $price < 100) {
            return back()
                ->withErrors(['price' => 'Paid posts must be at least $1.00'])
                ->withInput();
        }

        $post = Post::create([
            'creator_id' => $user->id,
            'body' => $data['body'],
            'type' => $data['type'],
            'is_paid' => $isPaid,
            'price' => $price,
            'status' => 'published',
            'published_at' => now(),
        ]);

        if ($request->hasFile('media')) {
            // Persistent private storage (paid media must never be a guessable public URL)
            $path = \App\Support\UploadStorage::storePrivate($request->file('media'), 'posts');
            $post->media()->create([
                'disk' => \App\Support\UploadStorage::disk(),
                'path' => $path,
                'type' => str_starts_with($request->file('media')->getMimeType() ?? '', 'video') ? 'video' : 'image',
                'sort_order' => 0,
            ]);
        }

        return redirect()
            ->route('posts.index')
            ->with('status', 'Post published');
    }

    public function show(Request $request, Post $post): RedirectResponse
    {
        $post->loadMissing('creator');

        return redirect()->route('profile.post', [
            'username' => $post->creator->username,
            'post' => $post,
        ], 301);
    }

    public function showOnProfile(Request $request, string $username, Post $post): View
    {
        $post->load(['creator.profile', 'media']);

        if (strcasecmp($username, $post->creator->username) !== 0) {
            abort(404);
        }

        $locked = $post->isLockedFor($request->user());

        return view('posts.show', compact('post', 'locked'));
    }
}
