<?php

namespace App\Console\Commands;

use App\Models\PostMedia;
use App\Support\UploadStorage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MovePaidMediaToPrivateDisk extends Command
{
    protected $signature = 'ffm:move-paid-media-to-private';

    protected $description = 'Copy paid post media to persistent S3 as PRIVATE. Safe to run twice; source deleted only after verify.';

    public function handle(): int
    {
        $target = UploadStorage::disk();
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

            $relative = UploadStorage::normalize($path);

            // Already on persistent private storage
            if ($media->disk === $target && Storage::disk($target)->exists($relative)) {
                $skipped++;
                continue;
            }

            // Find source object
            $fromDisk = null;
            $fromPath = null;
            foreach (array_unique(array_filter([$media->disk, 'public', 'local', $target])) as $disk) {
                if ($disk === $target) {
                    continue;
                }
                try {
                    foreach ([$relative, $path] as $candidate) {
                        if ($candidate && Storage::disk($disk)->exists($candidate)) {
                            $fromDisk = $disk;
                            $fromPath = $candidate;
                            break 2;
                        }
                    }
                } catch (\Throwable) {
                    continue;
                }
            }

            if ($fromDisk === null) {
                // Already only on S3 but row not marked — just retag
                if (Storage::disk($target)->exists($relative)) {
                    $media->update(['disk' => $target, 'path' => $relative]);
                    $moved++;
                    continue;
                }
                $this->warn("missing #{$media->id} disk={$media->disk} path={$path}");
                $missing++;
                continue;
            }

            // Copy to private S3, verify, then delete source
            Storage::disk($target)->put($relative, Storage::disk($fromDisk)->get($fromPath), [
                'visibility' => 'private',
            ]);

            if (! Storage::disk($target)->exists($relative)) {
                $this->error("write failed #{$media->id}");

                return self::FAILURE;
            }

            $media->update(['disk' => $target, 'path' => $relative]);

            if ($fromDisk !== $target && Storage::disk($fromDisk)->exists($fromPath)) {
                Storage::disk($fromDisk)->delete($fromPath);
            }

            $this->info("moved #{$media->id} {$fromDisk}:{$fromPath} -> {$target}:{$relative} (private)");
            $moved++;
        }

        $this->info("moved={$moved} skipped={$skipped} missing={$missing} target_disk={$target}");

        return self::SUCCESS;
    }
}
