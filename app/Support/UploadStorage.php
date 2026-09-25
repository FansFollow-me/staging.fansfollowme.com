<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Persistent upload storage (R2/S3). local/public disks are wiped on deploy.
 */
class UploadStorage
{
    /** Disk used for all user uploads (public + private keys live here). */
    public static function disk(): string
    {
        return (string) config('ffm.upload_disk', 's3');
    }

    /** Store a public-readable object (avatar, cover, free media, reels, stories). */
    public static function storePublic(UploadedFile $file, string $directory): string
    {
        $path = $file->store($directory, ['disk' => self::disk(), 'visibility' => 'public']);

        return ltrim((string) $path, '/');
    }

    /** Store a private object (paid media, vault, product files, video messages). */
    public static function storePrivate(UploadedFile $file, string $directory): string
    {
        $path = $file->store($directory, ['disk' => self::disk(), 'visibility' => 'private']);

        return ltrim((string) $path, '/');
    }

    /**
     * Public URL for a stored key.
     * Prefers the disk's public base URL when configured; otherwise the app
     * stream route (cacheable) so we never depend on env changes.
     */
    public static function publicUrl(string $path): string
    {
        $path = self::normalize($path);
        $disk = self::disk();

        if ($path !== '' && config("filesystems.disks.{$disk}.url")) {
            try {
                return Storage::disk($disk)->url($path);
            } catch (\Throwable) {
                // fall through to app route
            }
        }

        return route('uploads.public', ['path' => $path]);
    }

    public static function normalize(string $path): string
    {
        $path = ltrim($path, '/');
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }

        return $path;
    }

    public static function exists(string $path): bool
    {
        $path = self::normalize($path);

        return $path !== '' && Storage::disk(self::disk())->exists($path);
    }

    public static function response(string $path, ?string $name = null, bool $private = true)
    {
        $path = self::normalize($path);
        abort_if($path === '' || str_contains($path, '..'), 404);
        abort_unless(Storage::disk(self::disk())->exists($path), 404);

        $response = Storage::disk(self::disk())->response($path, $name);
        if (! $private) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
        }

        return $response;
    }

    public static function delete(string $path): void
    {
        $path = self::normalize($path);
        if ($path !== '' && Storage::disk(self::disk())->exists($path)) {
            Storage::disk(self::disk())->delete($path);
        }
    }
}
