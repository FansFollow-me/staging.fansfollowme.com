<?php

namespace App\Console\Commands;

use App\Models\PostMedia;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MovePaidMediaToPrivateDisk extends Command
{
    protected $signature = 'ffm:move-paid-media-to-private';

    protected $description = 'Move paid post media from the public disk to the private local disk. Safe to run twice.';

    public function handle(): int
    {
        $private = 'local';
        $moved = 0;
        $skipped = 0;
        $missing = 0;

        $rows = PostMedia::query()
            ->whereHas('post', fn ($q) => $q->where('is_paid', true))
            ->orderBy('id')
            ->get();

        foreach ($rows as $media) {
            $path = (string) $media->path;

            if ($path === '' || str_contains($path, '..')) {
                $skipped++;
                continue;
            }

            // Seeded marketing stills live in public/img, not uploaded storage.
            if (str_starts_with($path, 'img/') || str_starts_with($path, 'public/')) {
                $skipped++;
                continue;
            }

            $relative = str_starts_with($path, 'storage/')
                ? substr($path, strlen('storage/'))
                : ltrim($path, '/');

            if ($media->disk === $private && Storage::disk($private)->exists($relative)) {
                $skipped++;
                continue;
            }

            if (Storage::disk($private)->exists($relative)) {
                $media->update(['disk' => $private, 'path' => $relative]);
                $moved++;
                continue;
            }

            $fromDisk = null;
            $fromPath = null;
            foreach (array_unique(array_filter([$media->disk, 'public'])) as $disk) {
                if ($disk === $private) {
                    continue;
                }
                try {
                    if (Storage::disk($disk)->exists($relative)) {
                        $fromDisk = $disk;
                        $fromPath = $relative;
                        break;
                    }
                    if ($path !== $relative && Storage::disk($disk)->exists($path)) {
                        $fromDisk = $disk;
                        $fromPath = $path;
                        break;
                    }
                } catch (\Throwable) {
                    continue;
                }
            }

            if ($fromDisk === null) {
                $this->warn("missing #{$media->id} disk={$media->disk} path={$path}");
                $missing++;
                continue;
            }

            Storage::disk($private)->put($relative, Storage::disk($fromDisk)->get($fromPath));

            if (! Storage::disk($private)->exists($relative)) {
                $this->error("write failed #{$media->id}");

                return self::FAILURE;
            }

            $media->update(['disk' => $private, 'path' => $relative]);

            if (Storage::disk($fromDisk)->exists($fromPath)) {
                Storage::disk($fromDisk)->delete($fromPath);
            }

            $this->info("moved #{$media->id} {$fromDisk}:{$fromPath} -> {$private}:{$relative}");
            $moved++;
        }

        $this->info("moved={$moved} skipped={$skipped} missing={$missing}");

        return self::SUCCESS;
    }
}
