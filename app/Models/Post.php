<?php

namespace App\Models;

use App\Enums\PostType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = [
        'creator_id',
        'type',
        'body',
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

    public function isLockedFor(?User $user): bool
    {
        if (! $this->is_paid) {
            return false;
        }

        if (! $user) {
            return true;
        }

        if ($user->id === $this->creator_id || $user->isAdmin()) {
            return false;
        }

        $hasPpv = PpvPurchase::where('user_id', $user->id)
            ->where('post_id', $this->id)
            ->exists();

        if ($hasPpv) {
            return false;
        }

        $hasActiveSub = Subscription::where('fan_id', $user->id)
            ->where('creator_id', $this->creator_id)
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->exists();

        return ! $hasActiveSub;
    }
}
