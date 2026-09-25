<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\CreatorSetting;
use App\Models\JoinLink;
use App\Models\Post;
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
                    'price' => 1499,
                    'avatar' => 'img/casting/viking-avatar.jpg',
                    'cover' => 'img/casting/founder-viking.jpg',
                    'posts' => [
                        ['body' => 'On set. Last Kumite still hits.', 'image' => 'img/casting/viking-post.jpg', 'paid' => false, 'price' => 0],
                        ['body' => 'Building FansFollow.me in public. Exclusive drops and fight-camp notes here.', 'image' => 'img/marketing/Viking.png', 'paid' => false, 'price' => 0],
                        ['body' => 'Subscriber-only fight camp notes from this week.', 'image' => 'img/marketing/lastkumite.jpeg', 'paid' => true, 'price' => 499],
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
                    'price' => 999,
                    'avatar' => 'img/marketing/elitetarget.png',
                    'cover' => 'img/marketing/magnetic_fighters.png',
                    'posts' => [
                        ['body' => 'I am proud to be chosen as an Ambassador for this platform!', 'image' => 'img/marketing/magnetic_fighters.png', 'paid' => false, 'price' => 0],
                        ['body' => 'Pad work from this morning. Full round is for subscribers.', 'image' => 'img/marketing/Hard_redemption.png', 'paid' => true, 'price' => 499],
                    ],
                ],
                [
                    'username' => 'FFM-Martin',
                    'email' => 'ffmmartin@fansfollow.test',
                    'name' => 'FFM-Martin',
                    'bio' => 'FFM admin and creator. Platform updates, golf content, and community highlights.',
                    'category' => 'Admin',
                    'role' => UserRole::Admin,
                    'verified' => true,
                    'price' => 0,
                    'avatar' => 'logo-monogram.png',
                    'cover' => 'img/marketing/ffmherobackground.jpg',
                    'posts' => [
                        ['body' => 'Welcome to FansFollow.me — fitness, martial arts and combat sports creators.', 'image' => 'img/marketing/creators-hero-bg.jpg', 'paid' => false, 'price' => 0],
                        ['body' => 'New features shipping this week. Stay tuned.', 'image' => 'img/marketing/livestreaming.webp', 'paid' => false, 'price' => 0],
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
                        'avatar_path' => $row['avatar'] ?? null,
                        'cover_path' => $row['cover'] ?? null,
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
                            'subscription_price' => (int) ($row['price'] ?? 0),
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
                foreach ($row['posts'] as $postRow) {
                    $post = Post::updateOrCreate(
                        ['creator_id' => $account->id, 'body' => $postRow['body']],
                        [
                            'type' => ! empty($postRow['image']) ? 'photo' : 'text',
                            'is_paid' => (bool) ($postRow['paid'] ?? false),
                            'price' => (int) ($postRow['price'] ?? 0),
                            'status' => 'published',
                            'published_at' => now()->subHours(rand(2, 72)),
                        ]
                    );
                    if (! empty($postRow['image'])) {
                        $post->media()->updateOrCreate(
                            ['path' => $postRow['image']],
                            ['disk' => 'public', 'type' => 'image', 'sort_order' => 0]
                        );
                    }
                }
            }
        }

        $this->call(DemoContentSeeder::class);
    }
}
