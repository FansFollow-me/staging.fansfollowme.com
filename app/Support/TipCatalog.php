<?php

namespace App\Support;

/**
 * FFM tip gifts — Martin's locked unisex catalogue (2026-09-12).
 *
 * Rules:
 * - One unisex list (no men's/women's split — avoid backlash)
 * - Price = real-world value of the gift itself
 * - Animation intensity scales with tier only
 * - No trademarked brand names
 * - amounts are in cents
 */
class TipCatalog
{
    /** @return array<int, array{key:string,label:string,emoji:string,amount:int,blurb:string,tier:int,image:?string,mystery?:bool}> */
    public static function all(): array
    {
        return array_values(array_filter(static::raw(), fn ($g) => empty($g['hidden'])));
    }

    /** Full list including hidden legacy keys (for forKey lookups on old tips). */
    public static function raw(): array
    {
        return [
            ['key' => 'high_five', 'label' => 'High Five', 'emoji' => '✋', 'amount' => 200, 'blurb' => '$2 · Quick respect', 'tier' => 1, 'image' => 'high_five.png'],
            ['key' => 'protein_shake', 'label' => 'Protein Shake', 'emoji' => '🥤', 'amount' => 500, 'blurb' => '$5 · Post-session fuel', 'tier' => 1, 'image' => 'protein_shake.png'],
            // legacy key kept for old tip rows only
            ['key' => 'rose', 'label' => 'Protein Shake', 'emoji' => '🥤', 'amount' => 500, 'blurb' => '$5 · Post-session fuel', 'tier' => 1, 'image' => 'protein_shake.png', 'hidden' => true],
            ['key' => 'beer', 'label' => 'Bottle of Beer', 'emoji' => '🍺', 'amount' => 1000, 'blurb' => '$10 · Celebration', 'tier' => 2, 'image' => 'beer_bottle.png', 'glass' => 'glass_beer.png', 'pour' => 'beer'],
            ['key' => 'wine', 'label' => 'Glass of Wine', 'emoji' => '🍷', 'amount' => 2500, 'blurb' => '$25 · Refined', 'tier' => 2, 'image' => 'wine_bottle.png', 'glass' => 'glass_wine.png', 'pour' => 'wine'],
            ['key' => 'champagne', 'label' => 'Glass of Champagne', 'emoji' => '🥂', 'amount' => 5000, 'blurb' => '$50 · Toast', 'tier' => 3, 'image' => 'champagne.png', 'glass' => 'glass_flute.png', 'pour' => 'champagne'],
            ['key' => 'bouquet', 'label' => 'Bouquet of Roses', 'emoji' => '💐', 'amount' => 10000, 'blurb' => '$100 · Big gesture', 'tier' => 4, 'image' => 'bouquet.png', 'flowers' => true],
            ['key' => 'sunglasses', 'label' => 'Premium Sunglasses', 'emoji' => '🕶️', 'amount' => 25000, 'blurb' => '$250 · Style', 'tier' => 5, 'image' => 'sunglasses.png'],
            ['key' => 'shoes', 'label' => 'Luxury Shoes', 'emoji' => '👠', 'amount' => 50000, 'blurb' => '$500 · Statement', 'tier' => 5, 'image' => 'shoes.png'],
            ['key' => 'purse', 'label' => 'Luxury Purse', 'emoji' => '👛', 'amount' => 100000, 'blurb' => '$1,000 · Real luxury', 'tier' => 6, 'image' => 'purse.png'],
            ['key' => 'home_gym', 'label' => 'Home Gym', 'emoji' => '🏋️', 'amount' => 250000, 'blurb' => '$2,500 · Equipment money', 'tier' => 7, 'image' => 'home_gym.png'],
            ['key' => 'designer_bag', 'label' => 'Designer Bag', 'emoji' => '🛍️', 'amount' => 500000, 'blurb' => '$5,000 · Major gift', 'tier' => 8, 'image' => 'designer_bag.png'],
            ['key' => 'diamond_bracelet', 'label' => 'Diamond Bracelet', 'emoji' => '💎', 'amount' => 1000000, 'blurb' => '$10,000 · Precious', 'tier' => 9, 'image' => 'diamond_bracelet.png'],
            ['key' => 'luxury_watch', 'label' => 'Luxury Watch', 'emoji' => '⌚', 'amount' => 2500000, 'blurb' => '$25,000 · Timeless', 'tier' => 9, 'image' => 'luxury_watch.png'],
            ['key' => 'luxury_holiday', 'label' => 'Luxury Holiday', 'emoji' => '✈️', 'amount' => 5000000, 'blurb' => '$50,000 · Escape', 'tier' => 10, 'image' => 'luxury_holiday.png'],
            ['key' => 'sports_car', 'label' => 'Sports Car', 'emoji' => '🏎️', 'amount' => 10000000, 'blurb' => '$100,000 · Once-in-a-lifetime', 'tier' => 10, 'image' => 'sports_car.png'],
            ['key' => 'mystery_box', 'label' => 'Mystery Box', 'emoji' => '🎁', 'amount' => 25000000, 'blurb' => '$250,000 · Sealed surprise', 'tier' => 10, 'image' => 'mystery_box.png', 'mystery' => true],
        ];
    }

    public static function labels(): array
    {
        return array_column(static::all(), 'label', 'key');
    }

    public static function forKey(?string $key): ?array
    {
        if (! $key) {
            return null;
        }

        return collect(static::raw())->firstWhere('key', $key);
    }

    public static function tierFor(?string $key): int
    {
        $g = static::forKey($key);

        return (int) ($g['tier'] ?? 1);
    }

    /** Client-side metadata map for GiftFX */
    public static function jsMap(): array
    {
        $out = [];
        foreach (static::all() as $g) {
            $out[$g['key']] = [
                'emoji' => $g['emoji'],
                'label' => $g['label'],
                'amount' => $g['amount'],
                'tier' => $g['tier'],
                'image' => $g['image'] ? asset('img/gifts/'.$g['image']).'?v=palm1' : null,
                'glass' => ! empty($g['glass']) ? asset('img/gifts/'.$g['glass']).'?v=cutout3' : null,
                'pour' => $g['pour'] ?? null,
                'flowers' => ! empty($g['flowers']),
                'mystery' => ! empty($g['mystery']),
            ];
        }

        return $out;
    }
}
