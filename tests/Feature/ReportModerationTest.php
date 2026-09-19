<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportModerationTest extends TestCase
{
    use RefreshDatabase;

    private function user(UserRole $role = UserRole::Fan): User
    {
        $u = User::factory()->create(['role' => $role, 'username' => 'rep'.uniqid()]);
        $u->profile()->create(['display_name' => 'Rep']);
        $u->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        return $u;
    }

    public function test_user_can_report_post(): void
    {
        $creator = $this->user(UserRole::Creator);
        $fan = $this->user();
        $post = Post::create([
            'creator_id' => $creator->id,
            'body' => 'Bad content',
            'type' => 'text',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->actingAs($fan)->post('/reports', [
            'subject_type' => 'post',
            'subject_id' => $post->id,
            'reason' => 'spam',
            'details' => 'Looks spammy',
        ])->assertSessionHas('status');

        $this->assertDatabaseHas('reports', [
            'reporter_id' => $fan->id,
            'subject_type' => 'post',
            'subject_id' => $post->id,
            'status' => 'open',
        ]);
    }

    public function test_admin_can_remove_post_via_report(): void
    {
        $creator = $this->user(UserRole::Creator);
        $fan = $this->user();
        $admin = $this->user(UserRole::Admin);

        $post = Post::create([
            'creator_id' => $creator->id,
            'body' => 'Remove me',
            'type' => 'text',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $report = Report::create([
            'reporter_id' => $fan->id,
            'subject_type' => 'post',
            'subject_id' => $post->id,
            'reason' => 'abuse',
            'status' => 'open',
        ]);

        $this->actingAs($admin)->post('/panel/admin/reports/'.$report->id.'/resolve', [
            'action' => 'remove_content',
        ])->assertSessionHas('status');

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        $this->assertSame('actioned', $report->fresh()->status);
    }

    public function test_login_rate_limit_blocks_after_five_failures(): void
    {
        User::factory()->create([
            'username' => 'ratelimit',
            'email' => 'ratelimit@example.com',
        ]);

        for ($i = 0; $i < 5; $i++) {
            $this->from('/login')->post('/login', [
                'username_email' => 'ratelimit',
                'password' => 'wrong-password',
            ])->assertRedirect('/login');
        }

        $response = $this->from('/login')->post('/login', [
            'username_email' => 'ratelimit',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('username_email');
        $errors = session('errors')->get('username_email');
        $this->assertStringContainsString('Too many login attempts', $errors[0]);
    }
}
