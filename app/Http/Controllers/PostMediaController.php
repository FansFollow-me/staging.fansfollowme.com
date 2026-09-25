<?php

namespace App\Http\Controllers;

use App\Models\PostMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PostMediaController extends Controller
{
    /** Stream post media after lock check — prevents guessing storage URLs for paid posts. */
    public function show(Request $request, PostMedia $postMedia): Response
    {
        $postMedia->loadMissing('post');
        $post = $postMedia->post;

        abort_unless($post && $post->status === 'published', 404);

        $viewer = $request->user();
        $isOwner = $viewer && (int) $viewer->id === (int) $post->creator_id;

        if (! $isOwner) {
            abort_unless(! $post->isLockedFor($viewer), 403);
        }

        $path = (string) $postMedia->path;
        abort_if(str_contains($path, '..'), 404);

        foreach (array_unique(array_filter([$postMedia->disk ?: 'local', 'local', 'public'])) as $disk) {
            if (Storage::disk($disk)->exists($path)) {
                return Storage::disk($disk)->response($path);
            }
        }

        // Legacy seeded assets under public/img/...
        if (str_starts_with($path, 'img/') || str_starts_with($path, 'public/')) {
            $absolute = public_path(ltrim($path, '/'));
            if (is_file($absolute)) {
                return response()->file($absolute);
            }
        }

        abort(404);
    }
}
