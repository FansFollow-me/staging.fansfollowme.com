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

        $this->call(DemoContentSeeder::class);
    }
}
