<?php

namespace App\Enums;

enum UserRole: string
{
    case Fan = 'fan';
    case Creator = 'creator';
    case Admin = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::Fan => 'Fan',
            self::Creator => 'Creator',
            self::Admin => 'Admin',
        };
    }
}
