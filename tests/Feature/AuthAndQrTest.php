<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\JoinLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndQrTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_login(): void
    {
        $this->get('/login')->assertOk();
    }

    public function test_admin_routes_require_auth(): void
    {
        $this->get('/panel/admin')->assertRedirect('/login');
    }

    public function test_fan_cannot_access_admin_panel(): void
    {
        $user = User::factory()->create(['role' => UserRole::Fan]);
        $this->actingAs($user)->get('/panel/admin')->assertForbidden();
    }

    public function test_admin_can_access_admin_panel(): void
    {
        $user = User::factory()->create(['role' => UserRole::Admin]);
        $this->actingAs($user)->get('/panel/admin')->assertOk();
    }

    public function test_qr_join_shows_landing_and_tracks_scan(): void
    {
        $creator = User::factory()->create(['role' => UserRole::Creator, 'username' => 'qrcoach']);
        $link = JoinLink::create([
            'creator_id' => $creator->id,
            'code' => 'qrtest01',
            'is_active' => true,
            'follow_on_join' => true,
        ]);

        $this->get('/j/qrtest01')->assertRedirect();

        $this->assertDatabaseHas('join_events', [
            'join_link_id' => $link->id,
            'type' => 'scan',
        ]);
    }

    public function test_register_via_qr_attributes_referral(): void
    {
        $creator = User::factory()->create(['role' => UserRole::Creator, 'username' => 'qrcoach2']);
        $link = JoinLink::create([
            'creator_id' => $creator->id,
            'code' => 'qrtest02',
            'is_active' => true,
            'follow_on_join' => true,
        ]);

        $response = $this->withSession(['join_code' => 'qrtest02'])
            ->post('/signup', [
                'username' => 'newfan',
                'email' => 'newfan@example.com',
                'password' => 'Password123!',
                'password_confirmation' => 'Password123!',
                'role' => 'fan',
                'terms' => '1',
            'age_confirm' => '1',
            'date_of_birth' => now()->subYears(30)->format('Y-m-d'),
            ]);

        $response->assertSessionHasNoErrors();
        if ($response->status() !== 302 && $response->status() !== 200) {
            $this->fail('Unexpected status '.$response->status().' content: '.substr($response->getContent(), 0, 500));
        }
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'username' => 'newfan',
            'referred_by' => $creator->id,
        ]);
        $this->assertDatabaseHas('follows', [
            'follower_id' => User::where('username', 'newfan')->value('id'),
            'creator_id' => $creator->id,
        ]);
    }
}
