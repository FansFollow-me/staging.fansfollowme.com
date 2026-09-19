<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$coach = App\Models\User::where('username', 'vikingcoach')->first();
if (! $coach) {
    echo "no coach\n";
    exit(1);
}

$room = App\Models\LiveRoom::firstOrCreate(
    ['creator_id' => $coach->id, 'title' => 'Open mat — technique Q&A'],
    [
        'description' => 'Free public room. Gifts welcome while we drill.',
        'mode' => 'public',
        'access' => 'free',
        'status' => 'live',
        'allow_4k' => true,
        'provider' => 'agora',
    ]
);

echo "live=/live/{$room->id}\n";
