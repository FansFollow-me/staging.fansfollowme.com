<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductNavMenuTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(UserRole $role, string $username): User
    {
        $user = User::factory()->create(['role' => $role, 'username' => $username]);
        $user->profile()->create(['display_name' => $username]);
        $user->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        return $user;
    }

    public function test_fan_hamburger_items(): void
    {
        $fan = $this->makeUser(UserRole::Fan, 'navfan');

        $response = $this->actingAs($fan)->get('/dashboard')->assertOk();

        $response->assertSee('Home')
            ->assertSee('My profile')
            ->assertSee('Dashboard')
            ->assertSee('Messages')
            ->assertSee('Alerts')
            ->assertSee('Settings')
            ->assertSee('Wallet')
            ->assertSee('Log out');

        $response->assertDontSee('href="'.route('creator.dashboard').'"')
            ->assertDontSee('href="'.route('admin.dashboard').'"');
    }

    public function test_creator_hamburger_includes_studio(): void
    {
        $creator = $this->makeUser(UserRole::Creator, 'navcreator');

        $response = $this->actingAs($creator)->get('/creator/dashboard')->assertOk();

        $response->assertSee('Home')
            ->assertSee('My profile')
            ->assertSee('Studio')
            ->assertSee('Dashboard')
            ->assertSee('Messages')
            ->assertSee('Settings')
            ->assertSee('Wallet');

        $response->assertDontSee('href="'.route('admin.dashboard').'"');
    }

    public function test_admin_hamburger_includes_admin(): void
    {
        $admin = $this->makeUser(UserRole::Admin, 'navadmin');

        $response = $this->actingAs($admin)->get('/panel/admin')->assertOk();

        $response->assertSee('Home')
            ->assertSee('My profile')
            ->assertSee('Admin')
            ->assertSee('Settings')
            ->assertSee('Wallet');

        $response->assertDontSee('href="'.route('creator.dashboard').'"')
            ->assertDontSee('href="'.route('dashboard').'"');
    }
}
