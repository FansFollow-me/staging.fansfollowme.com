<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\VideoRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoMessageTest extends TestCase
{
    use RefreshDatabase;

    private function creator(array $tiers = []): User
    {
        $u = User::factory()->create([
            'role' => UserRole::Creator,
            'username' => 'vmc'.uniqid(),
        ]);
        $u->profile()->create(['display_name' => 'VM Coach']);
        $u->wallet()->create(['balance' => 0, 'currency' => 'USD']);
        $u->creatorSettings()->create(array_merge([
            'subscription_price' => 999,
            'accepts_subscriptions' => true,
            'video_tier1_price' => 5000,
            'video_tier2_price' => 10000,
            'video_tier3_price' => 20000,
            'video_messages_enabled' => true,
            'brand_promo_enabled' => true,
        ], $tiers));

        return $u;
    }

    private function fan(int $cents = 100000): User
    {
        $u = User::factory()->create([
            'role' => UserRole::Fan,
            'username' => 'vmf'.uniqid(),
        ]);
        $u->profile()->create(['display_name' => 'Fan']);
        $u->wallet()->create(['balance' => $cents, 'currency' => 'USD']);

        return $u;
    }

    public function test_request_page_lists_three_tiers_and_five_occasions(): void
    {
        $creator = $this->creator();
        $fan = $this->fan();

        $this->actingAs($fan)->get('/video-messages/request/'.$creator->id)
            ->assertOk()
            ->assertSee('Birthday')
            ->assertSee('Shoutout')
            ->assertSee('Promote your brand')
            ->assertSee('Short')
            ->assertSee('Medium')
            ->assertSee('Long');
    }

    public function test_tier2_charges_creator_set_price(): void
    {
        $creator = $this->creator();
        $fan = $this->fan(50000);

        $this->actingAs($fan)->post('/video-messages/request/'.$creator->id, [
            'occasion' => 'birthday',
            'tier' => 2,
            'brief' => 'Happy birthday coach!',
        ])->assertSessionHas('status');

        $this->assertSame(40000, $fan->fresh()->wallet->balance);
        $this->assertSame(10000, $creator->fresh()->wallet->balance);
        $this->assertDatabaseHas('video_requests', [
            'fan_id' => $fan->id,
            'creator_id' => $creator->id,
            'tier' => 2,
            'price' => 10000,
            'status' => 'pending',
        ]);
    }

    public function test_brand_set_price_uses_custom_amount(): void
    {
        $creator = $this->creator();
        $fan = $this->fan(50000);

        $this->actingAs($fan)->post('/video-messages/request/'.$creator->id, [
            'occasion' => 'promote_brand',
            'brand_mode' => 'set_price',
            'custom_price' => 250,
            'brief' => 'Promote our gym brand',
        ])->assertSessionHas('status');

        $this->assertSame(25000, $fan->fresh()->wallet->balance);
        $this->assertDatabaseHas('video_requests', [
            'occasion' => 'promote_brand',
            'price' => 25000,
            'status' => 'pending',
        ]);
    }

    public function test_brand_negotiate_does_not_charge_yet(): void
    {
        $creator = $this->creator();
        $fan = $this->fan(50000);

        $this->actingAs($fan)->post('/video-messages/request/'.$creator->id, [
            'occasion' => 'promote_brand',
            'brand_mode' => 'negotiate',
            'brief' => 'Need a quote for brand promo',
        ])->assertSessionHas('status');

        $this->assertSame(50000, $fan->fresh()->wallet->balance);
        $this->assertSame(0, $creator->fresh()->wallet->balance);
        $this->assertDatabaseHas('video_requests', [
            'occasion' => 'promote_brand',
            'price' => 0,
            'status' => 'pending_quote',
        ]);
    }

    public function test_creator_can_set_tier_prices(): void
    {
        $creator = $this->creator();

        $this->actingAs($creator)->post('/settings/video-pricing', [
            'video_tier1_price' => 25,
            'video_tier2_price' => 50,
            'video_tier3_price' => 75,
            'video_messages_enabled' => '1',
            'brand_promo_enabled' => '1',
        ])->assertSessionHas('status');

        $s = $creator->fresh()->creatorSettings;
        $this->assertSame(2500, $s->video_tier1_price);
        $this->assertSame(5000, $s->video_tier2_price);
        $this->assertSame(7500, $s->video_tier3_price);
    }

    public function test_fan_cannot_open_video_pricing(): void
    {
        $fan = $this->fan();
        $this->actingAs($fan)->get('/settings/video-pricing')->assertForbidden();
    }
}
