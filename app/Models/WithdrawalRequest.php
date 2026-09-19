<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WithdrawalRequest extends Model
{
    protected $fillable = [
        'creator_id',
        'amount',
        'currency',
        'method',
        'details',
        'status',
        'status_reason',
        'admin_note',
        'requested_at',
        'processed_at',
        'payout_method',
        'estimated_arrival',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'processed_at' => 'datetime',
            'requested_at' => 'datetime',
            'estimated_arrival' => 'date',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
