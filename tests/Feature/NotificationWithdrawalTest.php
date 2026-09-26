<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationWithdrawalTest extends TestCase
{
    use RefreshDatabase;

    private function creatorWithBalance(int $cents): User
    {
        $u = User::factory()->create([
            'role' => UserRole::Creator,
            'username' => 'wd'.uniqid(),
        ]);
        $u->profile()->create(['display_name' => 'WD']);
        $u->wallet()->create(['balance' => $cents, 'currency' => 'USD']);

        return $u;
    }

    public function test_tip_creates_notification_for_creator(): void
    {
        $creator = $this->creatorWithBalance(0);
        $fan = User::factory()->create(['role' => UserRole::Fan, 'username' => 'tipper'.uniqid()]);
        $fan->profile()->create(['display_name' => 'Tipper']);
        $fan->wallet()->create(['balance' => 5000, 'currency' => 'USD']);

        $this->actingAs($fan)->post('/tip/'.$creator->id, ['amount' => 500])
            ->assertSessionHas('status');

        $this->assertDatabaseHas('app_notifications', [
            'user_id' => $creator->id,
            'type' => 'tip',
        ]);
    }

    public function test_creator_can_request_withdrawal_and_funds_held(): void
    {
        $creator = $this->creatorWithBalance(50000);

        $this->actingAs($creator)->post('/my/withdrawals', [
            'amount' => 200,
            'method' => 'bank',
            'details' => 'IBAN123',
        ])->assertSessionHas('status');

        $this->assertSame(30000, $creator->fresh()->wallet->balance);
        $this->assertDatabaseHas('withdrawal_requests', [
            'creator_id' => $creator->id,
            'amount' => 20000,
            'status' => 'pending',
        ]);
    }

    public function test_admin_approve_and_reject_withdrawal(): void
    {
        $creator = $this->creatorWithBalance(30000);
        $admin = User::factory()->create(['role' => UserRole::Admin, 'username' => 'adm'.uniqid()]);
        $admin->profile()->create(['display_name' => 'Adm']);
        $admin->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        $this->actingAs($creator)->post('/my/withdrawals', [
            'amount' => 100,
            'method' => 'paypal',
            'details' => 'pay@x.com',
        ]);

        $w = WithdrawalRequest::first();
        $this->assertNotNull($w);

        $this->actingAs($admin)->post('/panel/admin/withdrawals/'.$w->id.'/approve')
            ->assertSessionHas('status');
        $this->assertSame('paid', $w->fresh()->status);

        $this->actingAs($creator)->post('/my/withdrawals', [
            'amount' => 50,
            'method' => 'bank',
            'details' => 'IBAN9',
        ]);
        $w2 = WithdrawalRequest::latest('id')->first();
        $balBeforeReject = $creator->fresh()->wallet->balance;

        $this->actingAs($admin)->post('/panel/admin/withdrawals/'.$w2->id.'/reject', [
            'status_reason' => 'Bank details incomplete',
        ]);
        $this->assertSame('rejected', $w2->fresh()->status);
        $this->assertSame($balBeforeReject + 5000, $creator->fresh()->wallet->balance);
    }

    public function test_notifications_inbox_marks_read(): void
    {
        $creator = $this->creatorWithBalance(0);
        $fan = User::factory()->create(['role' => UserRole::Fan, 'username' => 'ntip'.uniqid()]);
        $fan->profile()->create(['display_name' => 'N']);
        $fan->wallet()->create(['balance' => 1000, 'currency' => 'USD']);

        $this->actingAs($fan)->post('/tip/'.$creator->id, ['amount' => 100]);

        $this->actingAs($creator)->get('/notifications')->assertOk();
        $n = \App\Models\AppNotification::where('user_id', $creator->id)->first();
        $this->actingAs($creator)->post('/notifications/'.$n->id.'/read');
        $this->assertNotNull($n->fresh()->read_at);
    }

    public function test_fan_cannot_access_admin_withdrawals(): void
    {
        $fan = User::factory()->create(['role' => UserRole::Fan, 'username' => 'nowd'.uniqid()]);
        $fan->profile()->create(['display_name' => 'F']);
        $this->actingAs($fan)->get('/panel/admin/withdrawals')->assertForbidden();
    }

    public function test_fan_cannot_request_withdrawal(): void
    {
        $fan = User::factory()->create(['role' => UserRole::Fan, 'username' => 'nfw'.uniqid()]);
        $fan->profile()->create(['display_name' => 'F']);
        $fan->wallet()->create(['balance' => 50000, 'currency' => 'USD']);

        $this->actingAs($fan)->get('/my/withdrawals')->assertForbidden();
        $this->actingAs($fan)->post('/my/withdrawals', [
            'amount' => 100,
            'method' => 'bank',
        ])->assertForbidden();

        $this->assertDatabaseMissing('withdrawal_requests', ['creator_id' => $fan->id]);
        $this->assertSame(50000, $fan->fresh()->wallet->balance);
    }
}
