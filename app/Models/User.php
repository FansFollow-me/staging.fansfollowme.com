<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'status',
        'email_verified_at',
        'age_verified_at',
        'age_verification_method',
        'date_of_birth',
        'age_confirmed_at',
        'age_confirmation_ip',
        'referral_code',
        'referred_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'age_verified_at' => 'datetime',
            'date_of_birth' => 'date',
            'age_confirmed_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function creatorSettings(): HasOne
    {
        return $this->hasOne(CreatorSetting::class);
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function joinLinks(): HasMany
    {
        return $this->hasMany(JoinLink::class, 'creator_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'creator_id');
    }

    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'creator_id');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'creator_id', 'follower_id');
    }

    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(Conversation::class, 'conversation_user')
            ->withPivot('last_read_at')
            ->withTimestamps();
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isCreator(): bool
    {
        return $this->role === UserRole::Creator;
    }

    public function isFan(): bool
    {
        return $this->role === UserRole::Fan;
    }

    public function canAccessPanel(): bool
    {
        return $this->isAdmin();
    }

    public function displayName(): string
    {
        return $this->profile?->display_name ?: $this->username;
    }

    public function avatarUrl(): string
    {
        $path = $this->profile?->avatar_path;

        return $this->publicAssetUrl($path) ?: asset('logo-monogram.png');
    }

    public function coverUrl(): string
    {
        $custom = $this->publicAssetUrl($this->profile?->cover_path);
        if ($custom) {
            return $custom;
        }

        // Fallback only — never written to cover_path
        return asset('img/marketing/default-profile-cover.jpg');
    }

    private function publicAssetUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return $path;
        }
        // Repo / public assets (seeded demo images, logo)
        if (str_starts_with($path, 'img/')
            || str_starts_with($path, 'public/img/')
            || str_starts_with($path, 'logo-')
            || ! str_contains($path, '/')) {
            return asset($path);
        }

        return \App\Support\UploadStorage::publicUrl($path);
    }
}
