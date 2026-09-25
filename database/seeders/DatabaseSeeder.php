<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\CreatorSetting;
use App\Models\JoinLink;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('TestPass123!');

        $admin = User::updateOrCreate(
            ['email' => 'admin@fansfollow.test'],
            [
                'username' => 'Admin',
                'password' => $password,
                'role' => UserRole::Admin,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $admin->profile()->updateOrCreate(['user_id' => $admin->id], ['display_name' => 'Admin']);
        $admin->wallet()->updateOrCreate(['user_id' => $admin->id], ['balance' => 0, 'currency' => 'USD']);

        $fan = User::updateOrCreate(
            ['email' => 'testfan@fansfollow.test'],
            [
                'username' => 'testfan',
                'password' => $password,
                'role' => UserRole::Fan,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $fan->profile()->updateOrCreate(['user_id' => $fan->id], ['display_name' => 'Test Fan']);
        $fan->wallet()->updateOrCreate(['user_id' => $fan->id], ['balance' => 0, 'currency' => 'USD']);

        $creator = User::updateOrCreate(
            ['email' => 'testcreator@fansfollow.test'],
            [
                'username' => 'testcreator',
                'password' => $password,
                'role' => UserRole::Creator,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $creator->profile()->updateOrCreate(
            ['user_id' => $creator->id],
            ['display_name' => 'Test Creator', 'bio' => 'Fitness & martial arts creator']
        );
        $creator->wallet()->updateOrCreate(['user_id' => $creator->id], ['balance' => 0, 'currency' => 'USD']);
        $creator->creatorSettings()->updateOrCreate(
            ['user_id' => $creator->id],
            [
                'subscription_price' => 999,
                'currency' => 'USD',
                'accepts_subscriptions' => true,
                'is_verified' => true,
            ]
        );

        JoinLink::firstOrCreate(
            ['creator_id' => $creator->id],
            ['code' => 'testcreator', 'is_active' => true, 'follow_on_join' => true]
        );

        $freeCreator = User::updateOrCreate(
            ['email' => 'freecoach@fansfollow.test'],
            [
                'username' => 'freecoach',
                'password' => $password,
                'role' => UserRole::Creator,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $freeCreator->profile()->updateOrCreate(
            ['user_id' => $freeCreator->id],
            ['display_name' => 'Free Coach', 'bio' => 'Free training tips. Follow with no paywall.']
        );
        $freeCreator->wallet()->updateOrCreate(['user_id' => $freeCreator->id], ['balance' => 0, 'currency' => 'USD']);
        $freeCreator->creatorSettings()->updateOrCreate(
            ['user_id' => $freeCreator->id],
            [
                'subscription_price' => 0,
                'currency' => 'USD',
                'accepts_subscriptions' => false,
                'is_verified' => true,
            ]
        );

        // Staging-only showcase accounts shown on /explore (never production)
        $stagingHost = (string) config('app.url');
        $isStagingLike = app()->environment(['local', 'staging', 'testing'])
            || str_contains($stagingHost, 'staging');
        if ($isStagingLike) {
            $showcase = [
                [
                    'username' => 'VikingSamurai',
                    'email' => 'vikingsamurai@fansfollow.test',
                    'name' => 'David Kurzhal',
                    'bio' => 'Founder of FansFollow.me. Martial artist, bodybuilder, and entrepreneur building the creator economy.',
                    'category' => 'Founder',
                    'role' => UserRole::Creator,
                    'verified' => true,
                    'posts' => [
                        'Building FansFollow.me in public. Exclusive drops and fight-camp notes here.',
                        'Martial arts film casting calls are open for FFM creators.',
                    ],
                ],
                [
                    'username' => 'JusticeJimmy',
                    'email' => 'justicejimmy@fansfollow.test',
                    'name' => 'Justice Jimmy Millar',
                    'bio' => 'Pro fighter and ambassador. Sharing exclusive training footage, fight prep, and behind-the-scenes content.',
                    'category' => 'Ambassador',
                    'role' => UserRole::Creator,
                    'verified' => false,
                    'posts' => [
                        'I am proud to be chosen as an Ambassador for this platform!',
                        'Exclusive training footage and fight prep coming to my page.',
                    ],
                ],
                [
                    'username' => 'FFM-Martin',
                    'email' => 'ffmmartin@fansfollow.test',
                    'name' => 'FFM-Martin',
                    'bio' => 'FFM admin and creator. Platform updates, golf content, and community highlights.',
                    'category' => null,
                    'role' => UserRole::Admin,
                    'verified' => true,
                    'posts' => [
                        'Welcome to FansFollow.me — fitness, martial arts and combat sports creators.',
                        'New features shipping this week. Stay tuned.',
                    ],
                ],
            ];

            foreach ($showcase as $row) {
                $account = User::updateOrCreate(
                    ['email' => $row['email']],
                    [
                        'username' => $row['username'],
                        'password' => $password,
                        'role' => $row['role'],
                        'status' => 'active',
                        'email_verified_at' => now(),
                    ]
                );
                $account->profile()->updateOrCreate(
                    ['user_id' => $account->id],
                    [
                        'display_name' => $row['name'],
                        'bio' => $row['bio'],
                        'category' => $row['category'],
                    ]
                );
                $account->wallet()->updateOrCreate(
                    ['user_id' => $account->id],
                    ['balance' => 0, 'currency' => 'USD']
                );
                if ($row['role'] === UserRole::Creator || $row['role'] === UserRole::Admin) {
                    $account->creatorSettings()->updateOrCreate(
                        ['user_id' => $account->id],
                        [
                            'subscription_price' => 0,
                            'currency' => 'USD',
                            'accepts_subscriptions' => true,
                            'is_verified' => $row['verified'],
                        ]
                    );
                    JoinLink::firstOrCreate(
                        ['creator_id' => $account->id],
                        ['code' => str_replace('-', '', strtolower($row['username'])), 'is_active' => true, 'follow_on_join' => true]
                    );
                }
                foreach ($row['posts'] as $body) {
                    \App\Models\Post::firstOrCreate(
                        ['creator_id' => $account->id, 'body' => $body],
                        [
                            'type' => 'text',
                            'is_paid' => false,
                            'price' => 0,
                            'status' => 'published',
                            'published_at' => now()->subHours(rand(2, 72)),
                        ]
                    );
                }
            }
        }

        $this->call(DemoContentSeeder::class);
    }
}
