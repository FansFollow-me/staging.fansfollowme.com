<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class JoinLink extends Model
{
    protected $fillable = [
        'creator_id',
        'code',
        'campaign',
        'is_active',
        'follow_on_join',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'follow_on_join' => 'boolean',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(JoinEvent::class);
    }

    public static function generateCode(): string
    {
        do {
            $code = Str::lower(Str::random(8));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    public function url(): string
    {
        $base = rtrim(config('app.qr_base_url', config('app.url')), '/');

        return $base.'/j/'.$this->code;
    }
}
