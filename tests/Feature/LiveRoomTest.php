<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\LiveRoom;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LiveRoomTest extends TestCase
{
    use RefreshDatabase;

    private function creator(): User
    {
        $u = User::factory()->create(['role' => UserRole::Creator, 'username' => 'livecoach'.uniqid()]);
        $u->profile()->create(['display_name' => 'Live Coach']);
        $u->creatorSettings()->create(['subscription_price' => 999, 'accepts_subscriptions' => true]);

        return $u;
    }

    private function fan(): User
    {
        $u = User::factory()->create(['role' => UserRole::Fan, 'username' => 'livefan'.uniqid()]);
        $u->profile()->create(['display_name' => 'Fan']);
        $u->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        return $u;
    }

    public function test_creator_can_create_free_public_room(): void
    {
        $creator = $this->creator();

        $this->actingAs($creator)->post('/my/live', [
            'title' => 'Morning pads',
            'mode' => 'public',
            'access' => 'free',
            'allow_4k' => '1',
        ])->assertRedirect();

        $this->assertDatabaseHas('live_rooms', [
            'creator_id' => $creator->id,
            'title' => 'Morning pads',
            'access' => 'free',
            'mode' => 'public',
            'allow_4k' => true,
        ]);
    }

    public function test_free_public_room_allows_guest(): void
    {
        $creator = $this->creator();
        $room = LiveRoom::create([
            'creator_id' => $creator->id,
            'title' => 'Open mat',
            'mode' => 'public',
            'access' => 'free',
            'status' => 'live',
            'allow_4k' => true,
        ]);

        $this->assertTrue($room->canJoin(null));
        $this->get('/live/'.$room->id)->assertOk();
    }

    public function test_subscribers_only_blocks_guest_and_free_fan(): void
    {
        $creator = $this->creator();
        $room = LiveRoom::create([
            'creator_id' => $creator->id,
            'title' => 'VIP drill',
            'mode' => 'group',
            'access' => 'subscribers_only',
            'status' => 'live',
        ]);

        $this->assertFalse($room->canJoin(null));
        $this->assertFalse($room->canJoin($this->fan()));
    }

    public function test_subscriber_can_join_subscribers_only_room(): void
    {
        $creator = $this->creator();
        $fan = $this->fan();
        $room = LiveRoom::create([
            'creator_id' => $creator->id,
            'title' => 'VIP drill',
            'mode' => 'group',
            'access' => 'subscribers_only',
            'status' => 'live',
        ]);

        Subscription::create([
            'fan_id' => $fan->id,
            'creator_id' => $creator->id,
            'status' => 'active',
            'price' => 9.99,
            'started_at' => now(),
            'ends_at' => now()->addMonth(),
        ]);

        $this->assertTrue($room->canJoin($fan));
    }

    public function test_ppv_room_blocks_until_ticket(): void
    {
        $creator = $this->creator();
        $fan = $this->fan();
        $room = LiveRoom::create([
            'creator_id' => $creator->id,
            'title' => 'Paid seminar',
            'mode' => 'group',
            'access' => 'ppv',
            'price' => 25,
            'status' => 'live',
        ]);

        $this->assertFalse($room->canJoin($fan));
        // Ticket purchase path lands with live provider payments
    }

    public function test_fan_cannot_create_room(): void
    {
        $fan = $this->fan();
        $this->actingAs($fan)->get('/my/live')->assertForbidden();
    }
}
