<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionPriceTest extends TestCase
{
    use RefreshDatabase;

    private function makeCreator(string $username = 'pricecoach'): User
    {
        $creator = User::factory()->create(['role' => UserRole::Creator, 'username' => $username]);
        $creator->profile()->create(['display_name' => 'Coach']);
        $creator->wallet()->create(['balance' => 0, 'currency' => 'USD']);
        $creator->creatorSettings()->create([
            'subscription_price' => 1499,
            'currency' => 'USD',
            'accepts_subscriptions' => true,
        ]);

        return $creator;
    }

    public function test_creator_can_set_subscription_price_in_dollars(): void
    {
        $creator = $this->makeCreator();

        $this->actingAs($creator)
            ->put('/settings/page', [
                'display_name' => 'Coach',
                'bio' => 'hi',
                'subscription_price' => '9.99',
            ])
            ->assertSessionHas('status');

        $this->assertSame(999, (int) $creator->fresh()->creatorSettings->subscription_price);

        // Public profile button shows the new price
        $this->get('/'.$creator->username)
            ->assertOk()
            ->assertSee('Subscribe $9.99');
    }

    public function test_creator_can_make_profile_free(): void
    {
        $creator = $this->makeCreator();

        $this->actingAs($creator)
            ->put('/settings/page', [
                'display_name' => 'Coach',
                'subscription_free' => '1',
                'subscription_price' => '9.99',
            ])
            ->assertSessionHas('status');

        $this->assertSame(0, (int) $creator->fresh()->creatorSettings->subscription_price);

        $this->get('/'.$creator->username)
            ->assertOk()
            ->assertSee('Free to follow')
            ->assertDontSee('Subscribe $');
    }

    public function test_subscription_price_out_of_range_is_rejected(): void
    {
        $creator = $this->makeCreator();

        $this->actingAs($creator)
            ->put('/settings/page', [
                'display_name' => 'Coach',
                'subscription_price' => '0.50',
            ])
            ->assertSessionHasErrors('subscription_price');

        $this->actingAs($creator)
            ->put('/settings/page', [
                'display_name' => 'Coach',
                'subscription_price' => '150',
            ])
            ->assertSessionHasErrors('subscription_price');

        $this->assertSame(1499, (int) $creator->fresh()->creatorSettings->subscription_price);
    }

    public function test_existing_subscription_keeps_old_price(): void
    {
        $creator = $this->makeCreator();
        $fan = User::factory()->create(['role' => UserRole::Fan, 'username' => 'oldsubfan']);
        $fan->profile()->create(['display_name' => 'Fan']);
        $fan->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        Subscription::create([
            'fan_id' => $fan->id,
            'creator_id' => $creator->id,
            'status' => 'active',
            'price' => 1499,
            'currency' => 'USD',
            'provider' => 'wallet',
            'started_at' => now(),
            'ends_at' => now()->addMonth(),
        ]);

        $this->actingAs($creator)
            ->put('/settings/page', [
                'display_name' => 'Coach',
                'subscription_price' => '19.99',
            ])
            ->assertSessionHas('status');

        $this->assertSame(1999, (int) $creator->fresh()->creatorSettings->subscription_price);
        $this->assertSame(1499, (int) Subscription::where('fan_id', $fan->id)->first()->price);
    }
}
