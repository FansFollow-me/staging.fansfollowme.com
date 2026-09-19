<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders(): void
    {
        $this->get('/login')->assertOk()->assertSee('username_email', false);
    }

    public function test_fan_can_login_and_reach_dashboard(): void
    {
        $fan = User::factory()->create([
            'role' => UserRole::Fan,
            'username' => 'logintestfan',
            'email' => 'logintestfan@example.com',
        ]);

        $this->post('/login', [
            'username_email' => 'logintestfan',
            'password' => 'Password123!',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($fan);
        $this->get('/dashboard')->assertOk();
    }

    public function test_login_with_email_works(): void
    {
        User::factory()->create([
            'role' => UserRole::Fan,
            'username' => 'emailfan',
            'email' => 'emailfan@example.com',
        ]);

        $this->post('/login', [
            'username_email' => 'emailfan@example.com',
            'password' => 'Password123!',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticated();
    }

    public function test_creator_login_goes_to_studio(): void
    {
        User::factory()->create([
            'role' => UserRole::Creator,
            'username' => 'logincoach',
            'email' => 'logincoach@example.com',
        ]);

        $this->post('/login', [
            'username_email' => 'logincoach',
            'password' => 'Password123!',
        ])->assertRedirect('/creator/dashboard');

        $this->get('/creator/dashboard')->assertOk();
    }

    public function test_admin_login_and_admin_panel(): void
    {
        User::factory()->create([
            'role' => UserRole::Admin,
            'username' => 'loginadmin',
            'email' => 'loginadmin@example.com',
        ]);

        $this->post('/login', [
            'username_email' => 'loginadmin',
            'password' => 'Password123!',
        ])->assertRedirect('/panel/admin');

        $this->get('/panel/admin')->assertOk();
    }

    public function test_invalid_password_rejected(): void
    {
        User::factory()->create([
            'username' => 'badpass',
            'email' => 'badpass@example.com',
        ]);

        $response = $this->from('/login')->post('/login', [
            'username_email' => 'badpass',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('username_email');
        $this->assertGuest();
    }

    public function test_profile_route_does_not_shadow_dashboard(): void
    {
        User::factory()->create([
            'role' => UserRole::Fan,
            'username' => 'profilefan',
            'email' => 'profilefan@example.com',
        ]);

        $this->post('/login', [
            'username_email' => 'profilefan',
            'password' => 'Password123!',
        ]);

        $this->get('/dashboard')->assertOk();
        $this->get('/profilefan')->assertOk();
    }
}
