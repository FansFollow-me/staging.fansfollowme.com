<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoRequest extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_PENDING_QUOTE = 'pending_quote';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'fan_id',
        'creator_id',
        'price',
        'currency',
        'occasion',
        'tier',
        'brief',
        'status',
        'video_path',
        'completed_at',
        'rejected_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'completed_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    public function fan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'fan_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
