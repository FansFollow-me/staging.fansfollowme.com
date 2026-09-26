<?php

namespace App\Models;

use App\Enums\PostType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    public const ACCESS_FREE = 'free';
    public const ACCESS_SUBSCRIBERS = 'subscribers';
    public const ACCESS_PPV = 'ppv';

    public const ACCESS_OPTIONS = [
        self::ACCESS_FREE,
        self::ACCESS_SUBSCRIBERS,
        self::ACCESS_PPV,
    ];

    protected $fillable = [
        'creator_id',
        'type',
        'body',
        'access',
        'is_paid',
        'price',
        'status',
        'scheduled_at',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'type' => PostType::class,
            'is_paid' => 'boolean',
            'price' => 'integer',
            'scheduled_at' => 'datetime',
            'published_at' => 'datetime',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function media(): HasMany
    {
        return $this->hasMany(PostMedia::class);
    }

    public function isFree(): bool
    {
        return $this->access === self::ACCESS_FREE;
    }

    public function isSubscribersOnly(): bool
    {
        return $this->access === self::ACCESS_SUBSCRIBERS;
    }

    public function isPpv(): bool
    {
        return $this->access === self::ACCESS_PPV;
    }

    /**
     * FREE: always open.
     * SUBSCRIBERS: open to owner/admin/active subscriber.
     * PPV: open to owner/admin or after purchase — NOT to subscribers.
     */
    public function isLockedFor(?User $user): bool
    {
        if ($this->isFree()) {
            return false;
        }

        if (! $user) {
            return true;
        }

        if ($user->id === $this->creator_id || $user->isAdmin()) {
            return false;
        }

        if ($this->isPpv()) {
            return ! PpvPurchase::where('user_id', $user->id)
                ->where('post_id', $this->id)
                ->exists();
        }

        // subscribers-only
        return ! Subscription::where('fan_id', $user->id)
            ->where('creator_id', $this->creator_id)
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->exists();
    }

    public function accessLabel(): string
    {
        return match ($this->access) {
            self::ACCESS_SUBSCRIBERS => 'Subscribers',
            self::ACCESS_PPV => 'PPV $'.number_format($this->price / 100, 2),
            default => 'Free',
        };
    }
}
