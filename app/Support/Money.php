<?php

namespace App\Support;

/**
 * Creator-facing prices are entered in dollars and stored in cents.
 */
class Money
{
    public static function dollarsToCents(mixed $dollars): int
    {
        return (int) round(((float) $dollars) * 100);
    }

    public static function centsToInput(mixed $cents): string
    {
        return number_format(((int) $cents) / 100, 2, '.', '');
    }
}
