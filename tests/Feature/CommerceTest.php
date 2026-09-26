<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CommerceTest extends TestCase
{
    use RefreshDatabase;

    private function makeCreator(array $attrs = []): User
    {
        $creator = User::factory()->create(array_merge([
            'role' => UserRole::Creator,
            'username' => 'coach'.uniqid(),
        ], $attrs));

        $creator->profile()->create(['display_name' => 'Coach']);
        $creator->wallet()->create(['balance' => 0, 'currency' => 'USD']);
        $creator->creatorSettings()->create([
            'subscription_price' => 999,
            'currency' => 'USD',
            'accepts_subscriptions' => true,
        ]);

        return $creator;
    }

    private function makeFan(float $balance = 10000): User
    {
        $fan = User::factory()->create([
            'role' => UserRole::Fan,
            'username' => 'fan'.uniqid(),
        ]);
        $fan->profile()->create(['display_name' => 'Fan']);
        $fan->wallet()->create(['balance' => (int) $balance, 'currency' => 'USD']);

        return $fan;
    }

    public function test_fan_can_follow_creator(): void
    {
        $creator = $this->makeCreator();
        $fan = $this->makeFan();

        $this->actingAs($fan)->post('/follow/'.$creator->id)->assertRedirect();
        $this->assertTrue($fan->fresh()->following->contains($creator->id));
    }

    public function test_wallet_add_funds_starts_stripe_checkout(): void
    {
        $fan = $this->makeFan(0);

        config(['services.stripe.secret' => 'sk_test_fake']);
        Http::fake([
            'api.stripe.com/*' => Http::response([
                'url' => 'https://checkout.stripe.com/test/session_abc',
            ], 200),
        ]);

        $this->actingAs($fan)->post('/wallet/add-funds', ['amount' => 5000])
            ->assertRedirect('https://checkout.stripe.com/test/session_abc');

        // Checkout does not credit the wallet until the webhook confirms payment
        $this->assertSame(0, $fan->fresh()->wallet->balance);
    }

    public function test_wallet_add_funds_rejects_when_stripe_disabled(): void
    {
        $fan = $this->makeFan(0);
        config(['services.stripe.secret' => null]);

        $this->actingAs($fan)->post('/wallet/add-funds', ['amount' => 5000])
            ->assertSessionHasErrors('amount');

        $this->assertSame(0, $fan->fresh()->wallet->balance);
    }

    public function test_wallet_deposit_and_subscribe(): void
    {
        $creator = $this->makeCreator();
        $fan = $this->makeFan(5000);

        $this->actingAs($fan)->post('/subscribe/'.$creator->id)
            ->assertSessionHas('status');

        $this->assertSame(5000 - 999, $fan->fresh()->wallet->balance);
        $this->assertSame(999, $creator->fresh()->wallet->balance);
        $this->assertDatabaseHas('subscriptions', [
            'fan_id' => $fan->id,
            'creator_id' => $creator->id,
            'status' => 'active',
        ]);
    }

    public function test_tip_moves_wallet_balances(): void
    {
        $creator = $this->makeCreator();
        $fan = $this->makeFan(1000);

        $this->actingAs($fan)->post('/tip/'.$creator->id, ['amount' => 400])
            ->assertSessionHas('status');

        $this->assertSame(600, $fan->fresh()->wallet->balance);
        $this->assertSame(400, $creator->fresh()->wallet->balance);
        $this->assertDatabaseHas('tips', [
            'from_user_id' => $fan->id,
            'to_creator_id' => $creator->id,
            'amount' => 400,
        ]);
    }

    public function test_ppv_unlock_after_wallet_funds(): void
    {
        $creator = $this->makeCreator();
        $fan = $this->makeFan(2000);

        $post = Post::create([
            'creator_id' => $creator->id,
            'body' => 'Secret premium',
            'type' => 'text',
            'is_paid' => true,
            'price' => 500,
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->assertTrue($post->isLockedFor($fan));

        $this->actingAs($fan)->post('/posts/'.$post->id.'/unlock')
            ->assertRedirect(route('posts.show', $post));

        $this->assertFalse($post->fresh()->isLockedFor($fan));
        $this->assertSame(1500, $fan->fresh()->wallet->balance);
        $this->assertSame(500, $creator->fresh()->wallet->balance);
        $this->assertDatabaseHas('ppv_purchases', [
            'user_id' => $fan->id,
            'post_id' => $post->id,
            'amount' => 500,
        ]);
    }

    public function test_subscription_unlocks_paid_post_without_ppv(): void
    {
        $creator = $this->makeCreator();
        $fan = $this->makeFan(5000);

        $post = Post::create([
            'creator_id' => $creator->id,
            'body' => 'Subs only body',
            'type' => 'text',
            'is_paid' => true,
            'price' => 999,
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->actingAs($fan)->post('/subscribe/'.$creator->id);
        $this->assertFalse($post->fresh()->isLockedFor($fan));
    }

    public function test_insufficient_wallet_blocks_subscribe(): void
    {
        $creator = $this->makeCreator();
        $fan = $this->makeFan(100);

        $this->actingAs($fan)->post('/subscribe/'.$creator->id);
        $this->assertSame(100, $fan->fresh()->wallet->balance);
        $this->assertDatabaseMissing('subscriptions', [
            'fan_id' => $fan->id,
            'creator_id' => $creator->id,
        ]);
    }

    public function test_gift_tip_uses_catalog_amount_not_client_amount(): void
    {
        $creator = $this->makeCreator();
        $fan = $this->makeFan(100000);

        $this->actingAs($fan)->post('/tip/'.$creator->id, [
            'gift_key' => 'beer',
            'amount' => 1,
        ])->assertSessionHas('status');

        $this->assertDatabaseHas('tips', [
            'from_user_id' => $fan->id,
            'to_creator_id' => $creator->id,
            'gift_key' => 'beer',
            'amount' => 1000,
        ]);
        $this->assertSame(99000, $fan->fresh()->wallet->balance);
    }
}
