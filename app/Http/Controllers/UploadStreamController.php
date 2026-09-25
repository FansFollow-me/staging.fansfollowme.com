<?php

namespace App\Http\Controllers;

use App\Support\UploadStorage;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UploadStreamController extends Controller
{
    /**
     * Public upload prefixes only. Everything else (posts/, vault/, products/,
     * video-messages/, img/, …) is 404 even if the object exists.
     */
    private const PUBLIC_PREFIXES = [
        'profiles/',
        'stories/',
        'reels/', // includes reels/thumbs/
    ];

    /** Public media stream (avatars, covers, stories, reels). */
    public function public(Request $request, string $path): Response
    {
        $normalized = $this->normalizePublicPath($path);
        abort_if($normalized === null, 404);

        abort_unless($this->isAllowedPublicPath($normalized), 404);

        return UploadStorage::response($normalized, null, private: false);
    }

    /**
     * Decode + collapse path, then reject traversal. Returns null if unsafe.
     */
    private function normalizePublicPath(string $path): ?string
    {
        if ($path === '') {
            return null;
        }

        // Reject raw traversal / separator tricks before and after decoding.
        for ($i = 0; $i < 3; $i++) {
            if ($this->containsUnsafeSegments($path)) {
                return null;
            }
            $decoded = rawurldecode($path);
            if ($decoded === $path) {
                break;
            }
            $path = $decoded;
        }

        if ($this->containsUnsafeSegments($path)) {
            return null;
        }

        // Collapse duplicate slashes and strip a leading slash (no absolute paths).
        $path = preg_replace('#/+#', '/', $path, -1) ?? $path;
        $path = ltrim($path, '/');

        if ($path === '' || $this->containsUnsafeSegments($path)) {
            return null;
        }

        return $path;
    }

    private function containsUnsafeSegments(string $path): bool
    {
        return $path === ''
            || str_contains($path, "\0")
            || str_contains($path, '\\')
            || str_contains($path, '..')
            // Windows drive / scheme tricks
            || preg_match('#^[a-zA-Z]:#', $path) === 1
            || str_contains($path, '%2e')
            || str_contains($path, '%2E')
            || str_contains($path, '%2f')
            || str_contains($path, '%2F')
            || str_contains($path, '%5c')
            || str_contains($path, '%5C');
    }

    private function isAllowedPublicPath(string $path): bool
    {
        foreach (self::PUBLIC_PREFIXES as $prefix) {
            if (str_starts_with($path, $prefix) && ! str_contains(substr($path, strlen($prefix)), '..')) {
                return true;
            }
        }

        return false;
    }
}
