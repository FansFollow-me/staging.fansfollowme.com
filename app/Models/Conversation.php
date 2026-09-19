<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'last_message_at',
    ];

    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
        ];
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversation_user')
            ->withPivot('last_read_at')
            ->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function isParticipant(int $userId): bool
    {
        return $this->users()->whereKey($userId)->exists();
    }

    public static function findOrCreateBetween(int $a, int $b): self
    {
        $pair = collect([$a, $b])->sort()->values()->all();

        $existing = self::query()
            ->whereHas('users', fn ($q) => $q->where('users.id', $a))
            ->whereHas('users', fn ($q) => $q->where('users.id', $b))
            ->get()
            ->first(function ($c) use ($pair) {
                return $c->users->pluck('id')->sort()->values()->all() === $pair;
            });

        if ($existing) {
            return $existing;
        }

        $conversation = self::create(['last_message_at' => now()]);
        $conversation->users()->attach($pair);

        return $conversation;
    }
}
