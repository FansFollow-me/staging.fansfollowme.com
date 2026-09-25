<?php

namespace App\Http\Controllers;

use App\Support\UploadStorage;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UploadStreamController extends Controller
{
    /** Public media (avatars, covers, free post media, reels, stories). */
    public function public(Request $request, string $path): Response
    {
        abort_if(str_contains($path, '..'), 404);

        // Repo-seeded marketing stills (not uploads)
        if (str_starts_with($path, 'img/')) {
            $absolute = public_path($path);
            if (is_file($absolute)) {
                return response()->file($absolute, [
                    'Cache-Control' => 'public, max-age=31536000, immutable',
                ]);
            }
            abort(404);
        }

        return UploadStorage::response($path, null, private: false);
    }
}
