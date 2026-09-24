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
        // Prefer explicit QR_BASE_URL, then APP_URL (when not localhost), else current request host
        $base = config('app.qr_base_url');
        if (! $base || $base === 'http://localhost' || $base === 'https://localhost') {
            $base = config('app.url');
        }
        if (! $base || str_contains((string) $base, 'localhost') || str_contains((string) $base, '127.0.0.1')) {
            $request = request();
            if ($request) {
                $base = $request->getSchemeAndHttpHost();
            }
        }

        return rtrim((string) $base, '/').'/j/'.$this->code;
    }
}
