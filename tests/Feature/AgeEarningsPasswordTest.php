<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Tip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgeEarningsPasswordTest extends TestCase
{
    use RefreshDatabase;

    private function user(UserRole $role = UserRole::Fan): User
    {
        $u = User::factory()->create(['role' => $role, 'username' => 'ae'.uniqid()]);
        $u->profile()->create(['display_name' => 'AE']);
        $u->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        return $u;
    }

    public function test_self_declare_age_sets_verified_at(): void
    {
        $user = $this->user();
        $this->assertNull($user->age_verified_at);

        $this->actingAs($user)->post('/age/verification', [
            'confirm_age' => '1',
            'method' => 'self_declare',
        ])->assertRedirect('/dashboard');

        $this->assertNotNull($user->fresh()->age_verified_at);
    }

    public function test_third_party_age_method_rejected_without_keys(): void
    {
        $user = $this->user();
        $this->actingAs($user)->post('/age/verification', [
            'confirm_age' => '1',
            'method' => 'yoti',
        ])->assertSessionHasErrors('method');
    }

    public function test_creator_can_view_earnings(): void
    {
        $creator = $this->user(UserRole::Creator);
        Tip::create([
            'from_user_id' => $creator->id,
            'to_creator_id' => $creator->id,
            'amount' => 500,
            'currency' => 'USD',
        ]);

        $this->actingAs($creator)->get('/my/earnings')->assertOk();
    }

    public function test_password_reset_demo_flow(): void
    {
        $user = $this->user();

        $this->post('/password/reset', ['email' => $user->email])
            ->assertRedirect('/password/reset/form');

        $token = session('password_reset_token');
        $this->assertNotEmpty($token);

        $this->post('/password/reset/form', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'NewPass123!',
            'password_confirmation' => 'NewPass123!',
        ])->assertRedirect('/login');

        $this->post('/login', [
            'username_email' => $user->email,
            'password' => 'NewPass123!',
        ])->assertRedirect('/dashboard');
    }

    public function test_password_reset_rejects_bad_token(): void
    {
        $user = $this->user();
        $this->post('/password/reset', ['email' => $user->email]);

        $this->post('/password/reset/form', [
            'token' => 'wrong-token',
            'email' => $user->email,
            'password' => 'NewPass123!',
            'password_confirmation' => 'NewPass123!',
        ])->assertSessionHasErrors('token');
    }
}
