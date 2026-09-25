<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostMedia extends Model
{
    protected $fillable = [
        'post_id',
        'disk',
        'path',
        'type',
        'width',
        'height',
        'duration_seconds',
        'sort_order',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function url(): string
    {
        $path = (string) $this->path;
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return $path;
        }
        if ($this->disk === 'public' && ! str_starts_with($path, 'img/') && ! str_starts_with($path, 'posts/')) {
            return asset('storage/'.$path);
        }

        return asset($path);
    }
}
