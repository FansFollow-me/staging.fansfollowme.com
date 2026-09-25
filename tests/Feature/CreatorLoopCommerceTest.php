<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatorLoopCommerceTest extends TestCase
{
    use RefreshDatabase;

    private function makeCreator(string $username = 'viking'): User
    {
        $creator = User::factory()->create(['role' => UserRole::Creator, 'username' => $username]);
        $creator->profile()->create(['display_name' => 'David Kurzhal']);
        $creator->wallet()->create(['balance' => 0, 'currency' => 'USD']);
        $creator->creatorSettings()->create([
            'subscription_price' => 1499,
            'currency' => 'USD',
            'accepts_subscriptions' => true,
        ]);

        return $creator;
    }

    private function makeFan(string $username = 'testfan', float $balance = 20000): User
    {
        $fan = User::factory()->create(['role' => UserRole::Fan, 'username' => $username]);
        $fan->profile()->create(['display_name' => $username]);
        $fan->wallet()->create(['balance' => (int) $balance, 'currency' => 'USD']);

        return $fan;
    }

    public function test_follow_and_unfollow_write_to_database(): void
    {
        $creator = $this->makeCreator();
        $fan = $this->makeFan('loopfan1');

        $this->actingAs($fan)->post('/follow/'.$creator->id)->assertSessionHas('status');
        $this->assertDatabaseHas('follows', [
            'follower_id' => $fan->id,
            'creator_id' => $creator->id,
        ]);
        $this->assertTrue($fan->fresh()->following->contains($creator->id));

        // Profile shows Following state
        $this->actingAs($fan)->get('/'.$creator->username)->assertSee('Following');

        $this->actingAs($fan)->delete('/follow/'.$creator->id)->assertSessionHas('status');
        $this->assertFalse($fan->fresh()->following->contains($creator->id));
        $this->assertDatabaseMissing('follows', [
            'follower_id' => $fan->id,
            'creator_id' => $creator->id,
        ]);
    }

    public function test_subscribe_uses_wallet_and_persists_subscription(): void
    {
        $creator = $this->makeCreator();
        $fan = $this->makeFan('loopfan2', 5000);

        $this->actingAs($fan)->post('/subscribe/'.$creator->id)->assertSessionHas('status');

        $this->assertDatabaseHas('subscriptions', [
            'fan_id' => $fan->id,
            'creator_id' => $creator->id,
            'status' => 'active',
            'provider' => 'wallet',
        ]);
        $this->assertSame(5000 - 1499, $fan->fresh()->wallet->balance);
        $this->assertSame(1499, $creator->fresh()->wallet->balance);
    }

    public function test_subscribe_without_funds_is_rejected(): void
    {
        $creator = $this->makeCreator();
        $fan = $this->makeFan('loopfan3', 0);

        $this->actingAs($fan)->post('/subscribe/'.$creator->id)
            ->assertSessionHasErrors(['subscribe' => 'Add funds to your wallet first']);

        $this->assertSame(0, $fan->fresh()->wallet->balance);
        $this->assertDatabaseMissing('subscriptions', [
            'fan_id' => $fan->id,
            'creator_id' => $creator->id,
            'status' => 'active',
        ]);
    }
}
