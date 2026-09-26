<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\JoinLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QrJoinFlowTest extends TestCase
{
    use RefreshDatabase;

    private function paidCreator(string $code = 'qrpaid1'): array
    {
        $creator = User::factory()->create([
            'role' => UserRole::Creator,
            'username' => 'qrcoach'.uniqid(),
        ]);
        $creator->profile()->create(['display_name' => 'QR Coach', 'bio' => 'Paid coach']);
        $creator->wallet()->create(['balance' => 0, 'currency' => 'USD']);
        $creator->creatorSettings()->create([
            'subscription_price' => 1499,
            'accepts_subscriptions' => true,
        ]);
        $link = JoinLink::create([
            'creator_id' => $creator->id,
            'code' => $code,
            'is_active' => true,
            'follow_on_join' => true,
        ]);

        return [$creator, $link];
    }

    public function test_qr_landing_shows_paid_membership(): void
    {
        [$creator, $link] = $this->paidCreator('qrpaid2');

        $this->get('/j/'.$link->code)
            ->assertRedirect(route('profile', ['username' => $creator->username, 'ref' => $link->code]));

        $this->get('/'.$creator->username)
            ->assertOk()
            ->assertSee('Join')
            ->assertSee('Paid membership')
            ->assertSee('14.99');
    }

    public function test_qr_signup_redirects_to_creator_profile(): void
    {
        [$creator, $link] = $this->paidCreator('qrpaid3');

        $this->get('/j/'.$link->code)->assertRedirect(route('profile', ['username' => $creator->username, 'ref' => $link->code]));

        $this->post('/signup', [
            'username' => 'qrfan1',
            'email' => 'qrfan1@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'fan',
            'terms' => '1',
            'age_confirm' => '1',
            'date_of_birth' => now()->subYears(30)->format('Y-m-d'),
        ])->assertRedirect('/'.$creator->username);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'username' => 'qrfan1',
            'referred_by' => $creator->id,
        ]);
        $this->assertTrue(\App\Models\User::where('username', 'qrfan1')->first()->following->contains($creator->id));
    }

    public function test_logged_in_user_scanning_qr_goes_to_profile(): void
    {
        [$creator, $link] = $this->paidCreator('qrpaid4');
        $fan = User::factory()->create(['role' => UserRole::Fan, 'username' => 'existfan'.uniqid()]);
        $fan->profile()->create(['display_name' => 'F']);
        $fan->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        $this->actingAs($fan)->get('/j/'.$link->code)
            ->assertRedirect('/'.$creator->username);

        $this->assertTrue($fan->fresh()->following->contains($creator->id));
    }

    public function test_creator_sees_my_qr_under_more(): void
    {
        $creator = User::factory()->create(['role' => UserRole::Creator, 'username' => 'qrowner'.uniqid()]);
        $creator->profile()->create(['display_name' => 'Owner']);
        $creator->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        $this->actingAs($creator)->get('/my/qr')
            ->assertOk()
            ->assertSee('My QR Code')
            ->assertSee('qr-canvas-wrap')
            ->assertSee('qrcode.min.js')
            ->assertSee('Show Full Screen')
            ->assertSee('Download QR (PNG)');

        $link = JoinLink::where('creator_id', $creator->id)->first();
        $this->assertNotNull($link);
        $this->assertStringContainsString($creator->username.'?ref=', $link->url());
        $this->assertStringContainsString('ref='.urlencode($link->code), $link->url());
        $this->actingAs($creator)->get('/my/qr')->assertSee($link->url(), false);
    }
}
