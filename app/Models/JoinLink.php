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
        $this->loadMissing('creator');
        $username = $this->creator?->username;
        if ($username) {
            return rtrim($this->baseUrl(), '/').'/'.$username.($this->code ? '?ref='.rawurlencode($this->code) : '');
        }

        return rtrim($this->baseUrl(), '/').'/j/'.$this->code;
    }

    /**
     * Public origin for QR links: current request host when available,
     * otherwise APP_URL / QR_BASE_URL. Never localhost, never relative.
     */
    protected function baseUrl(): string
    {
        $request = request();
        if ($request) {
            $host = strtolower((string) $request->getHost());
            if ($host !== '' && ! $this->isLocalHost($host)) {
                // Phones must open a secure public URL
                return 'https://'.$host;
            }
        }

        foreach ([config('app.qr_base_url'), config('app.url')] as $candidate) {
            $base = $this->sanitizeBase($candidate);
            if ($base !== null) {
                return $base;
            }
        }

        if ($request) {
            return 'https://'.strtolower((string) $request->getHost());
        }

        return '';
    }

    protected function sanitizeBase(mixed $value): ?string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        $parts = parse_url($value);
        if (! is_array($parts) || empty($parts['host'])) {
            return null;
        }

        $host = strtolower($parts['host']);
        if ($this->isLocalHost($host)) {
            return null;
        }

        $scheme = strtolower($parts['scheme'] ?? 'https');
        if ($scheme !== 'https') {
            $scheme = 'https';
        }

        $port = isset($parts['port']) && ! in_array((int) $parts['port'], [80, 443], true)
            ? ':'.$parts['port']
            : '';

        return $scheme.'://'.$host.$port;
    }

    protected function isLocalHost(string $host): bool
    {
        return $host === 'localhost'
            || $host === '127.0.0.1'
            || $host === '::1'
            || str_ends_with($host, '.localhost')
            || str_starts_with($host, '127.');
    }
}