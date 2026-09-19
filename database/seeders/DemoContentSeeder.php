<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\CreatorSetting;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('TestPass123!');

        $creators = [
            ['username' => 'vikingcoach', 'name' => 'Viking Coach', 'bio' => 'Strength & combat conditioning. Former fighter.', 'cat' => 'Martial Arts', 'price' => 1499],
            ['username' => 'ironphysique', 'name' => 'Iron Physique', 'bio' => 'Hypertrophy coach. Contest prep specialist.', 'cat' => 'Bodybuilding', 'price' => 999],
            ['username' => 'matmonk', 'name' => 'Mat Monk', 'bio' => 'BJJ black belt. Technique every day.', 'cat' => 'Martial Arts', 'price' => 1299],
            ['username' => 'fuelbarbell', 'name' => 'Fuel Barbell', 'bio' => 'Olympic lifting + nutrition for fighters.', 'cat' => 'Fitness', 'price' => 799],
            ['username' => 'ringcraft', 'name' => 'Ringcraft', 'bio' => 'Boxing footwork & pad work programs.', 'cat' => 'Boxing', 'price' => 1199],
        ];

        $creatorIds = [];

        foreach ($creators as $c) {
            $user = User::updateOrCreate(
                ['email' => $c['username'].'@fansfollow.test'],
                [
                    'username' => $c['username'],
                    'password' => $password,
                    'role' => UserRole::Creator,
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'display_name' => $c['name'],
                    'bio' => $c['bio'],
                    'category' => $c['cat'],
                ]
            );

            $user->wallet()->updateOrCreate(['user_id' => $user->id], ['balance' => 0, 'currency' => 'USD']);

            $user->creatorSettings()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'subscription_price' => $c['price'],
                    'currency' => 'USD',
                    'accepts_subscriptions' => true,
                    'is_verified' => true,
                ]
            );

            $creatorIds[] = $user->id;
        }

        // Posts
        $bodies = [
            'Morning pad work — 5 rounds. Who is training today?',
            'New 8-week fight camp template is live in the shop.',
            'Tip jar open. Protein shake if this helped your session.',
            'Free drill: hip escape ladder. Save this.',
            'Going live tonight for Q&A on weight cuts.',
            'Technique Tuesday: jab-cross angle step.',
            'Recovery day. Mobility only. Sleep is a skill.',
            'Contest prep check-in — 6 weeks out.',
        ];

        foreach ($creatorIds as $i => $cid) {
            foreach (array_slice($bodies, 0, 4) as $j => $body) {
                $paid = ($j === 2 && $i % 2 === 0);
                Post::firstOrCreate(
                    [
                        'creator_id' => $cid,
                        'body' => $body,
                    ],
                    [
                        'type' => 'text',
                        'is_paid' => $paid,
                        'price' => $paid ? 499 : 0,
                        'status' => 'published',
                        'published_at' => now()->subHours(rand(1, 72)),
                    ]
                );
            }

            Product::firstOrCreate(
                ['creator_id' => $cid, 'title' => '8-Week Training Plan'],
                [
                    'description' => 'PDF program with weekly sessions and nutrition notes.',
                    'price' => 2999,
                    'currency' => 'USD',
                    'type' => 'digital',
                    'is_active' => true,
                ]
            );
        }

        // A couple of fans with balance so tips can demo instantly
        foreach (['demofan', 'superfan'] as $uname) {
            $fan = User::updateOrCreate(
                ['email' => $uname.'@fansfollow.test'],
                [
                    'username' => $uname,
                    'password' => $password,
                    'role' => UserRole::Fan,
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );
            $fan->profile()->updateOrCreate(['user_id' => $fan->id], ['display_name' => ucfirst($uname)]);
            $fan->wallet()->updateOrCreate(
                ['user_id' => $fan->id],
                ['balance' => 25000, 'currency' => 'USD']
            );
        }
    }
}
