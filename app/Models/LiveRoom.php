<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LiveRoom extends Model
{
    protected $fillable = [
        'creator_id',
        'title',
        'description',
        'mode',
        'access',
        'price',
        'status',
        'max_participants',
        'allow_4k',
        'provider',
        'provider_room_id',
        'started_at',
        'ended_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'allow_4k' => 'boolean',
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function canJoin(?User $user): bool
    {
        if (! $user) {
            return $this->access === 'free' && $this->mode === 'public';
        }

        if ($user->id === $this->creator_id || $user->isAdmin()) {
            return true;
        }

        return match ($this->access) {
            'free' => true,
            'subscribers_only' => Subscription::where('fan_id', $user->id)
                ->where('creator_id', $this->creator_id)
                ->where('status', 'active')
                ->where(function ($q) {
                    $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
                })
                ->exists(),
            'ppv' => false, // ticket purchase lands with live provider payments
            default => false,
        };
    }
}
