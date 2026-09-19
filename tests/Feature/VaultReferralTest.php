<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\VaultItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VaultReferralTest extends TestCase
{
    use RefreshDatabase;

    private function creator(string $name = null): User
    {
        $u = User::factory()->create([
            'role' => UserRole::Creator,
            'username' => $name ?: 'vaultcoach'.uniqid(),
        ]);
        $u->profile()->create(['display_name' => 'Coach']);
        $u->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        return $u;
    }

    public function test_creator_can_upload_and_list_vault(): void
    {
        Storage::fake('public');
        $creator = $this->creator();

        $this->actingAs($creator)->post('/my/vault', [
            'title' => 'Meal plan PDF',
            'file' => UploadedFile::fake()->create('meal.pdf', 100, 'application/pdf'),
        ])->assertSessionHas('status');

        $this->assertDatabaseHas('vault_items', [
            'creator_id' => $creator->id,
            'title' => 'Meal plan PDF',
        ]);

        $this->actingAs($creator)->get('/my/vault')->assertOk()->assertSee('Meal plan PDF');
    }

    public function test_fan_cannot_access_vault(): void
    {
        $fan = User::factory()->create(['role' => UserRole::Fan, 'username' => 'vaultfan'.uniqid()]);
        $fan->profile()->create(['display_name' => 'Fan']);
        $this->actingAs($fan)->get('/my/vault')->assertForbidden();
    }

    public function test_referral_link_and_register_attribution(): void
    {
        $creator = $this->creator('refcoach');

        $this->actingAs($creator)->get('/my/referrals')
            ->assertOk()
            ->assertSee('ref=refcoach');

        $this->app['auth']->forgetGuards();
        $this->flushSession();

        $this->post('/signup', [
            'username' => 'referredfan',
            'email' => 'referredfan@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'fan',
            'terms' => '1',
            'age_confirm' => '1',
            'date_of_birth' => now()->subYears(30)->format('Y-m-d'),
            'ref' => 'refcoach',
        ])->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'username' => 'referredfan',
            'referred_by' => $creator->id,
        ]);
    }

    public function test_vault_download_owner_only(): void
    {
        Storage::fake('public');
        $creator = $this->creator();
        $other = $this->creator();

        $item = VaultItem::create([
            'creator_id' => $creator->id,
            'title' => 'Secret',
            'path' => 'vault/x.pdf',
            'original_name' => 'secret.pdf',
            'size_bytes' => 10,
        ]);

        $this->actingAs($other)->get('/my/vault/'.$item->id.'/download')->assertForbidden();
    }
}
