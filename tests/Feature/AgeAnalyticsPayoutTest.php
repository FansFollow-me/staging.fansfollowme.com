<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgeAnalyticsPayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_under_18_cannot_register(): void
    {
        $this->post('/signup', [
            'username' => 'babyfan',
            'email' => 'babyfan@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'fan',
            'terms' => '1',
            'age_confirm' => '1',
            'date_of_birth' => now()->subYears(16)->format('Y-m-d'),
        ])->assertSessionHasErrors('date_of_birth');

        $this->assertDatabaseMissing('users', ['username' => 'babyfan']);
    }

    public function test_18_plus_registers_with_audit_fields(): void
    {
        $this->post('/signup', [
            'username' => 'adultfan',
            'email' => 'adultfan@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'fan',
            'terms' => '1',
            'age_confirm' => '1',
            'date_of_birth' => now()->subYears(25)->format('Y-m-d'),
        ])->assertRedirect();

        $user = User::where('username', 'adultfan')->first();
        $this->assertNotNull($user);
        $this->assertNotNull($user->date_of_birth);
        $this->assertNotNull($user->age_confirmed_at);
        $this->assertNotNull($user->age_confirmation_ip);
        $this->assertNull($user->age_verified_at);
    }

    public function test_missing_age_confirm_blocks_signup(): void
    {
        $this->post('/signup', [
            'username' => 'noflag',
            'email' => 'noflag@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'fan',
            'terms' => '1',
            'date_of_birth' => now()->subYears(30)->format('Y-m-d'),
        ])->assertSessionHasErrors('age_confirm');
    }

    public function test_creator_can_view_analytics(): void
    {
        $creator = User::factory()->create(['role' => UserRole::Creator, 'username' => 'anac'.uniqid()]);
        $creator->profile()->create(['display_name' => 'An']);
        $creator->wallet()->create(['balance' => 0, 'currency' => 'USD']);
        $creator->creatorSettings()->create(['subscription_price' => 999]);

        $this->actingAs($creator)->get('/my/analytics')->assertOk();
    }

    public function test_fan_cannot_view_analytics(): void
    {
        $fan = User::factory()->create(['role' => UserRole::Fan, 'username' => 'anaf'.uniqid()]);
        $fan->profile()->create(['display_name' => 'F']);
        $this->actingAs($fan)->get('/my/analytics')->assertForbidden();
    }

    public function test_withdrawal_shows_status_and_faq(): void
    {
        $creator = User::factory()->create(['role' => UserRole::Creator, 'username' => 'wdc'.uniqid()]);
        $creator->profile()->create(['display_name' => 'W']);
        $creator->wallet()->create(['balance' => 50000, 'currency' => 'USD']);

        $this->actingAs($creator)->post('/my/withdrawals', [
            'amount' => 100,
            'method' => 'bank',
            'details' => 'IBAN1',
        ]);

        $this->actingAs($creator)->get('/my/withdrawals')
            ->assertOk()
            ->assertSee('Payout FAQ')
            ->assertSee('under review');
    }

    public function test_reject_requires_reason(): void
    {
        $creator = User::factory()->create(['role' => UserRole::Creator, 'username' => 'wdr'.uniqid()]);
        $creator->profile()->create(['display_name' => 'W']);
        $creator->wallet()->create(['balance' => 50000, 'currency' => 'USD']);
        $admin = User::factory()->create(['role' => UserRole::Admin, 'username' => 'wda'.uniqid()]);
        $admin->profile()->create(['display_name' => 'A']);
        $admin->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        $this->actingAs($creator)->post('/my/withdrawals', [
            'amount' => 100,
            'method' => 'bank',
        ]);
        $w = \App\Models\WithdrawalRequest::first();

        $this->actingAs($admin)->post('/panel/admin/withdrawals/'.$w->id.'/reject')
            ->assertSessionHasErrors('status_reason');
    }
}
