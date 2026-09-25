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
        // Always go through the gated media route (lock check + no guessable storage URL)
        return route('posts.media', ['postMedia' => $this->id]);
    }
}
