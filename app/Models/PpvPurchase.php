<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpvPurchase extends Model
{
    protected $table = 'ppv_purchases';

    protected $fillable = [
        'user_id',
        'post_id',
        'amount',
        'currency',
        'provider',
        'provider_charge_id',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
