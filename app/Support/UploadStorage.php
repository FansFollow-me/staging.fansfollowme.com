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
        return self::store($file, $directory, 'public');
    }

    /** Store a private object (paid media, vault, product files, video messages). */
    public static function storePrivate(UploadedFile $file, string $directory): string
    {
        return self::store($file, $directory, 'private');
    }

    private static function store(UploadedFile $file, string $directory, string $visibility): string
    {
        if (! $file->isValid()) {
            throw new \RuntimeException($file->getErrorMessage() ?: 'Upload failed.');
        }

        $path = $file->store($directory, [
            'disk' => self::disk(),
            'visibility' => $visibility,
        ]);

        if (! is_string($path) || $path === '') {
            throw new \RuntimeException('File was not written to storage.');
        }

        $path = ltrim($path, '/');
        if (! Storage::disk(self::disk())->exists($path)) {
            throw new \RuntimeException('File was not written to storage.');
        }

        return $path;
    }

    /**
     * Public URL for a stored key.
     * Prefers the disk's public base URL when configured; otherwise the app
     * stream route (cacheable) so we never depend on env changes.
     */
    public static function publicUrl(string $path): string
    {
        // Always stream through the app route. R2/S3 public URLs can 401
        // even when the object exists; /media/{path} is the reliable source.
        return route('uploads.public', ['path' => self::normalize($path)]);
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
