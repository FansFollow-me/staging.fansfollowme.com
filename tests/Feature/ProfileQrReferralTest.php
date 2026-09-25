<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\JoinEvent;
use App\Models\JoinLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileQrReferralTest extends TestCase
{
    use RefreshDatabase;

    private function makeCreatorWithLink(string $username = 'viking', string $code = 'vikingsamurai'): User
    {
        $creator = User::factory()->create(['role' => UserRole::Creator, 'username' => $username]);
        $creator->profile()->create(['display_name' => 'David Kurzhal']);
        $creator->wallet()->create(['balance' => 0, 'currency' => 'USD']);
        $creator->creatorSettings()->create([
            'subscription_price' => 0,
            'currency' => 'USD',
            'accepts_subscriptions' => true,
            'is_verified' => true,
        ]);
        JoinLink::create([
            'creator_id' => $creator->id,
            'code' => $code,
            'is_active' => true,
            'follow_on_join' => true,
        ]);

        return $creator;
    }

    public function test_profile_ref_url_stores_ref_and_counts_scan(): void
    {
        $creator = $this->makeCreatorWithLink('viking', 'refcode01');
        $link = JoinLink::where('code', 'refcode01')->firstOrFail();

        $this->get('/viking?ref=refcode01')->assertOk();

        $this->assertDatabaseHas('join_events', [
            'join_link_id' => $link->id,
            'type' => 'scan',
        ]);
    }

    public function test_join_short_link_redirects_to_profile_with_ref_and_counts_scan(): void
    {
        $creator = $this->makeCreatorWithLink('viking', 'refcode02');
        $link = JoinLink::where('code', 'refcode02')->firstOrFail();

        $this->get('/j/refcode02')
            ->assertRedirect(route('profile', ['username' => 'viking', 'ref' => 'refcode02']));

        $this->assertDatabaseHas('join_events', [
            'join_link_id' => $link->id,
            'type' => 'scan',
        ]);
    }

    public function test_signup_from_profile_ref_credits_referred_by(): void
    {
        $creator = $this->makeCreatorWithLink('viking', 'refcode03');
        $link = JoinLink::where('code', 'refcode03')->firstOrFail();

        // Land on profile with ref (persists join_code + scan)
        $this->get('/viking?ref=refcode03')->assertOk();

        $this->post('/signup', [
            'username' => 'reffan1',
            'email' => 'reffan1@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'fan',
            'terms' => '1',
            'age_confirm' => '1',
            'date_of_birth' => now()->subYears(30)->format('Y-m-d'),
        ])->assertSessionHasNoErrors();

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'username' => 'reffan1',
            'referred_by' => $creator->id,
        ]);
        $this->assertDatabaseHas('join_events', [
            'join_link_id' => $link->id,
            'type' => 'signup',
            'user_id' => User::where('username', 'reffan1')->value('id'),
        ]);
        $this->assertTrue(
            User::where('username', 'reffan1')->first()->following->contains($creator->id)
        );
    }

    public function test_qr_share_url_is_profile_with_ref(): void
    {
        $creator = $this->makeCreatorWithLink('viking', 'refcode04');
        $link = JoinLink::where('code', 'refcode04')->firstOrFail();

        $this->assertStringEndsWith('/viking?ref=refcode04', $link->url());
    }
}
