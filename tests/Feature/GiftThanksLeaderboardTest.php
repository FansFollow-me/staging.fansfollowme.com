<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Tip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GiftThanksLeaderboardTest extends TestCase
{
    use RefreshDatabase;

    private function creator(string $name = null): User
    {
        $u = User::factory()->create([
            'role' => UserRole::Creator,
            'username' => $name ?: 'gtc'.uniqid(),
        ]);
        $u->profile()->create(['display_name' => 'Coach']);
        $u->wallet()->create(['balance' => 0, 'currency' => 'USD']);
        $u->creatorSettings()->create(['subscription_price' => 999, 'accepts_subscriptions' => true]);

        return $u;
    }

    private function fan(string $name = null): User
    {
        $u = User::factory()->create([
            'role' => UserRole::Fan,
            'username' => $name ?: 'gtf'.uniqid(),
        ]);
        $u->profile()->create(['display_name' => 'Fan']);
        $u->wallet()->create(['balance' => 500000, 'currency' => 'USD']);

        return $u;
    }

    public function test_creator_can_thank_fan_and_fan_gets_notification(): void
    {
        $creator = $this->creator();
        $fan = $this->fan();

        $this->actingAs($fan)->post('/tip/'.$creator->id, [
            'gift_key' => 'protein_shake',
        ])->assertSessionHas('status');

        $tip = Tip::first();
        $this->assertNotNull($tip);

        $this->actingAs($creator)->post('/gifts/'.$tip->id.'/thank', [
            'reaction' => 'thanks',
        ])->assertSessionHas('status');

        $this->assertNotNull($tip->fresh()->thanked_at);
        $this->assertSame('thanks', $tip->fresh()->reaction);

        $this->assertDatabaseHas('app_notifications', [
            'user_id' => $fan->id,
            'type' => 'gift_thanks',
        ]);
    }

    public function test_fan_cannot_thank_own_tip_on_creator_behalf_wrong_creator(): void
    {
        $creator = $this->creator();
        $other = $this->creator();
        $fan = $this->fan();

        $this->actingAs($fan)->post('/tip/'.$creator->id, ['gift_key' => 'protein_shake']);
        $tip = Tip::first();

        $this->actingAs($other)->post('/gifts/'.$tip->id.'/thank')->assertForbidden();
    }

    public function test_leaderboard_ranks_by_total(): void
    {
        $creator = $this->creator('boardcoach');
        $big = $this->fan('bigspender');
        $small = $this->fan('smallspender');

        $this->actingAs($big)->post('/tip/'.$creator->id, ['gift_key' => 'champagne']);
        $this->actingAs($big)->post('/tip/'.$creator->id, ['gift_key' => 'champagne']);
        $this->actingAs($small)->post('/tip/'.$creator->id, ['gift_key' => 'protein_shake']);

        $this->app['auth']->forgetGuards();
        $this->flushSession();

        $this->get('/boardcoach/gifts?period=all')
            ->assertOk()
            ->assertSee('bigspender')
            ->assertSee('smallspender');

        $html = $this->get('/boardcoach/gifts?period=all')->getContent();
        $this->assertTrue(strpos($html, 'bigspender') < strpos($html, 'smallspender'));
    }

    public function test_creator_gifts_inbox_lists_tips(): void
    {
        $creator = $this->creator();
        $fan = $this->fan();
        $this->actingAs($fan)->post('/tip/'.$creator->id, ['gift_key' => 'beer']);

        $this->actingAs($creator)->get('/my/gifts')->assertOk()->assertSee('Bottle of Beer');
    }
}
