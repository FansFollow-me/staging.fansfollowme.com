<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Post;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostAccessTypesTest extends TestCase
{
    use RefreshDatabase;

    private function makeCreator(string $username = 'accesscoach'): User
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

    private function makeFan(string $username, float $balance = 5000): User
    {
        $fan = User::factory()->create(['role' => UserRole::Fan, 'username' => $username]);
        $fan->profile()->create(['display_name' => $username]);
        $fan->wallet()->create(['balance' => (int) $balance, 'currency' => 'USD']);

        return $fan;
    }

    private function subscribe(User $fan, User $creator): void
    {
        Subscription::create([
            'fan_id' => $fan->id,
            'creator_id' => $creator->id,
            'status' => 'active',
            'price' => 14.99,
            'currency' => 'USD',
            'provider' => 'wallet',
            'started_at' => now(),
            'ends_at' => now()->addMonth(),
        ]);
    }

    private function publish(User $creator, string $access, int $price = 0): Post
    {
        $this->actingAs($creator)->post('/my/posts', [
            'body' => 'Access demo',
            'type' => 'text',
            'access' => $access,
            'price' => number_format($price / 100, 2, '.', ''),
        ])->assertRedirect('/my/posts');

        return Post::where('creator_id', $creator->id)->latest('id')->firstOrFail();
    }

    public function test_free_post_is_visible_to_everyone(): void
    {
        $creator = $this->makeCreator();
        $post = $this->publish($creator, 'free');

        $this->assertFalse($post->isLockedFor(null));
        $this->assertFalse($post->isLockedFor($this->makeFan('freefan1')));

        $this->get('/'.$creator->username.'/'.$post->id)
            ->assertOk()
            ->assertSee('Access demo');
    }

    public function test_subscribers_only_post_rules(): void
    {
        $creator = $this->makeCreator();
        $post = $this->publish($creator, 'subscribers');

        $this->assertTrue($post->isLockedFor(null));
        $this->assertTrue($post->isLockedFor($this->makeFan('nosub1')));
        $this->assertFalse($post->isLockedFor($creator));

        $sub = $this->makeFan('hassub1');
        $this->subscribe($sub, $creator);
        $this->assertFalse($post->isLockedFor($sub));

        // Badge
        $this->actingAs($creator)->get('/'.$creator->username.'/'.$post->id)
            ->assertOk()
            ->assertSee('Subscribers');
    }

    public function test_ppv_stays_locked_for_subscribers_until_purchased(): void
    {
        $creator = $this->makeCreator();
        $post = $this->publish($creator, 'ppv', 499);

        $sub = $this->makeFan('subppv1', 10000);
        $this->subscribe($sub, $creator);
        $this->assertTrue($post->isLockedFor($sub));

        $this->actingAs($sub)->post('/posts/'.$post->id.'/unlock')->assertRedirect();
        $this->assertFalse($post->fresh()->isLockedFor($sub));
        $this->assertDatabaseHas('ppv_purchases', [
            'user_id' => $sub->id,
            'post_id' => $post->id,
            'amount' => 499,
        ]);

        $this->actingAs($creator)->get('/'.$creator->username.'/'.$post->id)
            ->assertOk()
            ->assertSee('PPV $4.99');
    }

    public function test_guest_sees_login_cta_on_locked_post(): void
    {
        $creator = $this->makeCreator();
        $post = $this->publish($creator, 'subscribers');

        $this->get('/'.$creator->username.'/'.$post->id)
            ->assertOk()
            ->assertSee('Log in to unlock');
    }

    public function test_ppv_unlock_add_funds_when_balance_low(): void
    {
        $creator = $this->makeCreator();
        $post = $this->publish($creator, 'ppv', 499);
        $fan = $this->makeFan('brokefan', 100);

        $this->actingAs($fan)
            ->post('/posts/'.$post->id.'/unlock')
            ->assertSessionHasErrors(['unlock' => 'Add funds to your wallet first']);

        $this->actingAs($fan)->get('/'.$creator->username.'/'.$post->id)
            ->assertOk()
            ->assertSee('Add funds');
    }

    public function test_owner_always_sees_own_posts(): void
    {
        $creator = $this->makeCreator();
        $ppv = $this->publish($creator, 'ppv', 999);
        $subs = $this->publish($creator, 'subscribers');

        $this->assertFalse($ppv->isLockedFor($creator));
        $this->assertFalse($subs->isLockedFor($creator));
        $this->actingAs($creator)->get('/'.$creator->username.'/'.$ppv->id)->assertOk();
        $this->actingAs($creator)->get('/'.$creator->username.'/'.$subs->id)->assertOk();
    }
}
