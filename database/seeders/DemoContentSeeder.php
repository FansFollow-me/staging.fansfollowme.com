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

        $testCreator = User::where('username', 'testcreator')->first();
        if ($testCreator) {
            foreach ([
                ['body' => 'Open gym today. Drop in and train. Free for everyone following.', 'paid' => false, 'price' => 0],
                ['body' => 'Footwork ladder you can film on your phone. Free drill.', 'paid' => false, 'price' => 0],
                ['body' => 'Subscriber-only fight camp notes: 12-week peak week.', 'paid' => true, 'price' => 499],
                ['body' => 'Paid film breakdown: last kumite pad round.', 'paid' => true, 'price' => 999],
            ] as $post) {
                Post::firstOrCreate(
                    ['creator_id' => $testCreator->id, 'body' => $post['body']],
                    [
                        'type' => 'text',
                        'is_paid' => $post['paid'],
                'access' => $post['paid'] ? 'ppv' : 'free',
                        'price' => $post['price'],
                        'status' => 'published',
                        'published_at' => now()->subHours(rand(2, 48)),
                    ]
                );
            }
        }

        $freeCreator = User::where('username', 'freecoach')->first();
        if ($freeCreator) {
            foreach ([
                'Mobility flow you can do in 8 minutes. No paywall.',
                'Bodyweight circuit: 4 rounds, rest as needed.',
                'How I cue a jab without wrecking the shoulder.',
            ] as $body) {
                Post::firstOrCreate(
                    ['creator_id' => $freeCreator->id, 'body' => $body],
                    [
                        'type' => 'text',
                        'is_paid' => false,
                'access' => 'free',
                        'price' => 0,
                        'status' => 'published',
                        'published_at' => now()->subHours(rand(1, 24)),
                    ]
                );
            }
        }

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
                    'access' => $paid ? 'ppv' : 'free',
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
