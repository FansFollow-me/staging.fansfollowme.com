<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreatorSetting extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_price',
        'currency',
        'welcome_message',
        'video_call_price',
        'audio_call_price',
        'is_verified',
        'accepts_subscriptions',
        'video_tier1_price',
        'video_tier2_price',
        'video_tier3_price',
        'video_messages_enabled',
        'brand_promo_enabled',
    ];

    protected function casts(): array
    {
        return [
            'subscription_price' => 'integer',
            'video_call_price' => 'integer',
            'audio_call_price' => 'integer',
            'video_tier1_price' => 'integer',
            'video_tier2_price' => 'integer',
            'video_tier3_price' => 'integer',
            'video_messages_enabled' => 'boolean',
            'brand_promo_enabled' => 'boolean',
            'is_verified' => 'boolean',
            'accepts_subscriptions' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
