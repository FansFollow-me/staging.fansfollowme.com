<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JoinEvent extends Model
{
    public const TYPE_SCAN = 'scan';
    public const TYPE_SIGNUP = 'signup';
    public const TYPE_FIRST_PURCHASE = 'first_purchase';

    protected $fillable = [
        'join_link_id',
        'type',
        'user_id',
        'ip_hash',
        'user_agent',
    ];

    public function joinLink(): BelongsTo
    {
        return $this->belongsTo(JoinLink::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
