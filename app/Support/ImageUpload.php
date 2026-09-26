<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Photo pipeline: resize, respect EXIF orientation, strip GPS/EXIF, store JPEG.
 * Only the processed image is written to the upload disk.
 */
class ImageUpload
{
    public const MAX_UPLOAD_KB = 20480; // 20MB

    public const KIND_AVATAR = 'avatar';
    public const KIND_COVER = 'cover';
    public const KIND_POST = 'post';

    /** Store a processed photo and return the storage key. */
    public static function store(UploadedFile $file, string $directory, string $kind, string $visibility = 'public'): string
    {
        if (! $file->isValid()) {
            throw new \RuntimeException(self::uploadErrorMessage($file));
        }

        $binary = self::process($file, $kind);

        $name = 'img-'.uniqid('', true).'.jpg';
        $path = trim($directory, '/').'/'.$name;

        Storage::disk(UploadStorage::disk())->put($path, $binary, [
            'visibility' => $visibility,
        ]);

        if (! Storage::disk(UploadStorage::disk())->exists($path)) {
            throw new \RuntimeException('File was not written to storage.');
        }

        return $path;
    }

    /** Processed JPEG bytes (resized, orientation-corrected, EXIF stripped). */
    public static function process(UploadedFile $file, string $kind): string
    {
        $mime = strtolower((string) ($file->getMimeType() ?: ''));
        $ext = strtolower($file->getClientOriginalExtension() ?: '');
        $isHeic = str_contains($mime, 'heic') || str_contains($mime, 'heif')
            || in_array($ext, ['heic', 'heif'], true);

        if ($isHeic && ! self::heicSupported()) {
            throw new \RuntimeException('HEIC is not supported on this server. Please upload a JPG, PNG, or WebP photo.');
        }

        $src = self::loadSource($file, $mime, $ext);
        if (! $src) {
            throw new \RuntimeException('Could not read this image. Please upload a JPG, PNG, or WebP photo.');
        }

        $orientation = self::exifOrientation($file->getRealPath());
        $src = self::applyOrientation($src, $orientation);

        $maxW = 0;
        $maxH = 0;
        $maxSide = 0;
        if ($kind === self::KIND_AVATAR) {
            $maxW = $maxH = 800;
            $maxSide = 800;
        } elseif ($kind === self::KIND_COVER) {
            $maxW = 2400;
        } else {
            $maxSide = 2048;
        }

        $out = self::resize($src, $maxW, $maxH, $maxSide);
        imagedestroy($src);

        // GD JPEG encode drops all EXIF (including GPS).
        ob_start();
        $ok = imagejpeg($out, null, 85);
        $bytes = ob_get_clean();
        imagedestroy($out);

        if (! $ok || ! is_string($bytes) || $bytes === '') {
            throw new \RuntimeException('Could not encode the processed image.');
        }

        return $bytes;
    }

    public static function uploadErrorMessage(UploadedFile $file): string
    {
        $code = $file->getError();
        if (in_array($code, [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
            return 'Image too large for the server; try a smaller photo.';
        }
        if ($code === UPLOAD_ERR_PARTIAL) {
            return 'Image upload was interrupted; please try again.';
        }

        return $file->getErrorMessage() ?: 'Upload failed.';
    }

    /** True when a request field was sent but PHP dropped/failed the upload. */
    public static function hasFailedUpload(?UploadedFile $file): bool
    {
        return $file instanceof UploadedFile && ! $file->isValid();
    }

    public static function heicSupported(): bool
    {
        return extension_loaded('imagick')
            || (extension_loaded('gd') && function_exists('imagecreatefromstring'));
    }

    private static function loadSource(UploadedFile $file, string $mime, string $ext)
    {
        $path = $file->getRealPath();
        if (! $path || ! is_file($path)) {
            return false;
        }

        // Prefer EXIF-free load; imagecreatefrom* does not preserve GPS.
        if (str_contains($mime, 'jpeg') || in_array($ext, ['jpg', 'jpeg'], true)) {
            return @imagecreatefromjpeg($path);
        }
        if (str_contains($mime, 'png') || $ext === 'png') {
            return @imagecreatefrompng($path);
        }
        if (str_contains($mime, 'webp') || $ext === 'webp') {
            return function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false;
        }

        // HEIC/other via Imagick if present
        if (extension_loaded('imagick')) {
            try {
                $im = new \Imagick($path);
                $im->autoOrient();
                $im->stripImage();
                $im->setImageFormat('jpeg');
                $blob = $im->getImageBlob();
                $im->clear();
                return @imagecreatefromstring($blob);
            } catch (\Throwable) {
                return false;
            }
        }

        return @imagecreatefromstring((string) file_get_contents($path));
    }

    private static function exifOrientation(?string $path): int
    {
        if (! $path || ! function_exists('exif_read_data')) {
            return 1;
        }
        try {
            $exif = @exif_read_data($path);
        } catch (\Throwable) {
            return 1;
        }

        return (int) ($exif['Orientation'] ?? 1);
    }

    /** Bake EXIF orientation into pixels (phone portraits). */
    private static function applyOrientation($src, int $orientation)
    {
        if ($orientation === 1 || ! $src) {
            return $src;
        }

        $rotated = $src;
        if (in_array($orientation, [3, 4], true)) {
            $rotated = imagerotate($src, 180, 0);
        } elseif (in_array($orientation, [5, 6], true)) {
            $rotated = imagerotate($src, -90, 0);
        } elseif (in_array($orientation, [7, 8], true)) {
            $rotated = imagerotate($src, 90, 0);
        }

        if (in_array($orientation, [2, 4, 5, 7], true)) {
            $w = imagesx($rotated);
            $h = imagesy($rotated);
            $flipped = imagecreatetruecolor($w, $h);
            imagecopyresampled($flipped, $rotated, 0, 0, $w - 1, 0, $w, $h, -$w, $h);
            if ($rotated !== $src) {
                imagedestroy($rotated);
            }
            $rotated = $flipped;
        }

        if ($rotated !== $src && $src) {
            imagedestroy($src);
        }

        return $rotated;
    }

    private static function resize($src, int $maxW, int $maxH, int $maxSide)
    {
        $sw = imagesx($src);
        $sh = imagesy($src);
        if ($sw < 1 || $sh < 1) {
            throw new \RuntimeException('Invalid image dimensions.');
        }

        $scale = 1.0;
        if ($maxW > 0 && $sw > $maxW) {
            $scale = min($scale, $maxW / $sw);
        }
        if ($maxH > 0 && $sh > $maxH) {
            $scale = min($scale, $maxH / $sh);
        }
        if ($maxSide > 0) {
            $long = max($sw, $sh);
            if ($long > $maxSide) {
                $scale = min($scale, $maxSide / $long);
            }
        }

        $dw = max(1, (int) round($sw * $scale));
        $dh = max(1, (int) round($sh * $scale));

        $out = imagecreatetruecolor($dw, $dh);
        imagealphablending($out, false);
        imagesavealpha($out, true);
        $transparent = imagecolorallocatealpha($out, 0, 0, 0, 127);
        imagefilledrectangle($out, 0, 0, $dw, $dh, $transparent);

        imagecopyresampled($out, $src, 0, 0, 0, 0, $dw, $dh, $sw, $sh);

        return $out;
    }
}
