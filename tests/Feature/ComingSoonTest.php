<?php

namespace Tests\Feature;

use App\Models\FeatureRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComingSoonTest extends TestCase
{
    use RefreshDatabase;

    public function test_coming_soon_page_is_public(): void
    {
        $this->get('/coming-soon')
            ->assertOk()
            ->assertSee('Creator Competitions')
            ->assertSee('Mini Leagues')
            ->assertSee('Custom Video Messages');
    }

    public function test_guest_can_submit_feedback(): void
    {
        $this->post('/coming-soon/feedback', [
            'feature' => 'competitions',
            'message' => 'Monthly gym challenge with prizes',
        ])->assertSessionHas('status');

        $this->assertDatabaseHas('feature_requests', [
            'feature' => 'competitions',
            'message' => 'Monthly gym challenge with prizes',
            'user_id' => null,
        ]);
    }

    public function test_logged_in_feedback_records_user(): void
    {
        $user = \App\Models\User::factory()->create(['username' => 'fbfan'.uniqid()]);
        $user->profile()->create(['display_name' => 'FB']);

        $this->actingAs($user)->post('/coming-soon/feedback', [
            'feature' => 'mini_leagues',
            'message' => 'Want scoreboards',
        ]);

        $this->assertDatabaseHas('feature_requests', [
            'feature' => 'mini_leagues',
            'user_id' => $user->id,
        ]);
    }
}
