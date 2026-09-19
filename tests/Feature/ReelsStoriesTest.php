<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Reel;
use App\Models\Story;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReelsStoriesTest extends TestCase
{
    use RefreshDatabase;

    private function creator(): User
    {
        $u = User::factory()->create([
            'role' => UserRole::Creator,
            'username' => 'reelcoach'.uniqid(),
        ]);
        $u->profile()->create(['display_name' => 'Reel Coach']);
        $u->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        return $u;
    }

    public function test_creator_can_create_reel(): void
    {
        Storage::fake('public');
        $creator = $this->creator();

        $video = UploadedFile::fake()->create('reel.mp4', 1024, 'video/mp4');

        $this->actingAs($creator)->post('/create/reel', [
            'caption' => 'Morning sparring',
            'video' => $video,
        ])->assertRedirect('/reels');

        $this->assertDatabaseHas('reels', [
            'creator_id' => $creator->id,
            'caption' => 'Morning sparring',
            'status' => 'published',
        ]);
    }

    public function test_creator_can_create_story(): void
    {
        $creator = $this->creator();

        $this->actingAs($creator)->post('/create/story', [
            'type' => 'text',
            'body' => 'Training day',
        ])->assertRedirect('/stories');

        $this->assertDatabaseHas('stories', [
            'creator_id' => $creator->id,
            'type' => 'text',
            'body' => 'Training day',
        ]);
    }

    public function test_public_can_view_reels_feed(): void
    {
        $creator = $this->creator();
        Reel::create([
            'creator_id' => $creator->id,
            'caption' => 'Public reel',
            'video_path' => 'reels/test.mp4',
            'status' => 'published',
        ]);

        $this->get('/reels')->assertOk()->assertSee('Public reel');
    }

    public function test_public_can_view_stories_feed(): void
    {
        $creator = $this->creator();
        Story::create([
            'creator_id' => $creator->id,
            'type' => 'text',
            'body' => 'Active story',
            'expires_at' => now()->addHours(1),
        ]);

        $this->get('/stories')->assertOk()->assertSee($creator->username);
    }

    public function test_fan_cannot_create_reel(): void
    {
        $fan = User::factory()->create(['role' => UserRole::Fan, 'username' => 'reelfan'.uniqid()]);
        $fan->profile()->create(['display_name' => 'Fan']);
        $fan->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        $this->actingAs($fan)->get('/create/reel')->assertForbidden();
    }

    public function test_expired_story_not_shown(): void
    {
        $creator = $this->creator();
        $story = Story::create([
            'creator_id' => $creator->id,
            'type' => 'text',
            'body' => 'Old story',
            'expires_at' => now()->subHour(),
        ]);

        $this->get('/stories/'.$story->id)->assertNotFound();
    }
}
