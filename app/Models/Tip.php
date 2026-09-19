<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tip extends Model
{
    protected $fillable = [
        'from_user_id',
        'to_creator_id',
        'post_id',
        'amount',
        'currency',
        'message',
        'gift_key',
        'provider',
        'provider_charge_id',
        'thanked_at',
        'reaction',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'thanked_at' => 'datetime',
        ];
    }

    public function from(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_creator_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
