<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\FeatureRequest;
use App\Models\Tip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminInsightTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_sees_feature_requests(): void
    {
        $admin = User::factory()->create(['role' => UserRole::Admin, 'username' => 'admfi'.uniqid()]);
        $admin->profile()->create(['display_name' => 'A']);
        $admin->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        FeatureRequest::create(['feature' => 'mini_leagues', 'message' => 'Want leagues']);

        $this->actingAs($admin)->get('/panel/admin/feature-requests')
            ->assertOk()
            ->assertSee('mini_leagues');
    }

    public function test_fan_cannot_open_admin_gifts(): void
    {
        $fan = User::factory()->create(['role' => UserRole::Fan, 'username' => 'nog'.uniqid()]);
        $fan->profile()->create(['display_name' => 'F']);
        $this->actingAs($fan)->get('/panel/admin/gifts')->assertForbidden();
    }

    public function test_live_room_shows_gift_feed(): void
    {
        $creator = User::factory()->create(['role' => UserRole::Creator, 'username' => 'lgc'.uniqid()]);
        $creator->profile()->create(['display_name' => 'LG']);
        $creator->wallet()->create(['balance' => 0, 'currency' => 'USD']);
        $creator->creatorSettings()->create(['subscription_price' => 0, 'accepts_subscriptions' => true]);

        $fan = User::factory()->create(['role' => UserRole::Fan, 'username' => 'lgf'.uniqid()]);
        $fan->profile()->create(['display_name' => 'F']);
        $fan->wallet()->create(['balance' => 10000, 'currency' => 'USD']);

        $this->actingAs($fan)->post('/tip/'.$creator->id, ['gift_key' => 'protein_shake']);

        $room = \App\Models\LiveRoom::create([
            'creator_id' => $creator->id,
            'title' => 'Open mat',
            'mode' => 'public',
            'access' => 'free',
            'status' => 'live',
            'allow_4k' => true,
        ]);

        $this->get('/live/'.$room->id)
            ->assertOk()
            ->assertSee('Live gift wall')
            ->assertSee('Protein Shake');
    }
}
