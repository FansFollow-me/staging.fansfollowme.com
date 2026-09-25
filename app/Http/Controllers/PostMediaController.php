<?php

namespace App\Http\Controllers;

use App\Models\PostMedia;
use App\Support\UploadStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PostMediaController extends Controller
{
    /** Stream post media after lock check — private S3 object, never a guessable public URL. */
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

        $path = UploadStorage::normalize((string) $postMedia->path);
        abort_if($path === '' || str_contains($path, '..'), 404);

        $persistent = UploadStorage::disk();
        foreach (array_unique(array_filter([$postMedia->disk, $persistent, 'local', 'public'])) as $disk) {
            try {
                if (Storage::disk($disk)->exists($path)) {
                    return Storage::disk($disk)->response($path);
                }
            } catch (\Throwable) {
                continue;
            }
        }

        if (str_starts_with($path, 'img/')) {
            $absolute = public_path($path);
            if (is_file($absolute)) {
                return response()->file($absolute);
            }
        }

        abort(404);
    }
}
