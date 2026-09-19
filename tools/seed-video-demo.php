<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$fan = App\Models\User::where('username','demofan')->first();
if ($fan) {
  $fan->wallet()->updateOrCreate(['user_id'=>$fan->id],['balance'=>25000,'currency'=>'USD']);
  echo "fan funded\n";
}
$coach = App\Models\User::where('username','vikingcoach')->first();
if ($coach) {
  $coach->creatorSettings()->updateOrCreate(['user_id'=>$coach->id],[
    'subscription_price'=>1499,
    'video_tier1_price'=>5000,
    'video_tier2_price'=>10000,
    'video_tier3_price'=>20000,
    'video_messages_enabled'=>true,
    'brand_promo_enabled'=>true,
  ]);
  echo "coach id={$coach->id} pricing set\n";
}
