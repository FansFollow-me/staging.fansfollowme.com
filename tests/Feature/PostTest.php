<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_fan_cannot_create_posts(): void
    {
        $fan = User::factory()->create(['role' => UserRole::Fan]);
        $this->actingAs($fan)->get('/my/posts/create')->assertForbidden();
    }

    public function test_creator_can_publish_free_post(): void
    {
        $creator = User::factory()->create(['role' => UserRole::Creator]);

        $this->actingAs($creator)
            ->post('/my/posts', [
                'body' => 'Free training tip for everyone',
                'type' => 'text',
                'access' => 'free',
            ])
            ->assertRedirect('/my/posts');

        $this->assertDatabaseHas('posts', [
            'creator_id' => $creator->id,
            'access' => 'free',
            'status' => 'published',
        ]);
    }

    public function test_creator_can_publish_paid_post(): void
    {
        $creator = User::factory()->create(['role' => UserRole::Creator]);

        $this->actingAs($creator)
            ->post('/my/posts', [
                'body' => 'Premium coaching breakdown',
                'type' => 'text',
                'is_paid' => '1',
            'access' => 'ppv',
                'price' => '999',
            ])
            ->assertRedirect('/my/posts');

        $this->assertDatabaseHas('posts', [
            'creator_id' => $creator->id,
            'access' => 'ppv',
            'price' => 999,
        ]);
    }

    public function test_paid_post_blocks_guest_body(): void
    {
        $creator = User::factory()->create(['role' => UserRole::Creator]);
        $this->actingAs($creator)->post('/my/posts', [
            'body' => 'Secret premium content body',
            'type' => 'text',
            'access' => 'ppv',
            'price' => '499',
        ]);

        $post = $creator->posts()->first();
        $this->assertNotNull($post);

        // Drop the acting-as user so the next request is a guest
        $this->app['auth']->forgetGuards();
        $this->flushSession();

        $response = $this->get('/posts/'.$post->id);
        $response->assertStatus(301);
        $response->assertRedirect('/'.$creator->username.'/'.$post->id);

        $page = $this->get('/'.$creator->username.'/'.$post->id);
        $page->assertOk();
        $page->assertDontSee('Secret premium content body');
        $page->assertSee('Subscribe to unlock');
    }

    public function test_guest_can_see_free_post_body(): void
    {
        $creator = User::factory()->create(['role' => UserRole::Creator]);
        $this->actingAs($creator)->post('/my/posts', [
            'body' => 'Open free content',
            'type' => 'text',
            'access' => 'free',
        ]);
        $post = $creator->posts()->first();

        $this->app['auth']->forgetGuards();
        $this->flushSession();

        $this->get('/posts/'.$post->id)
            ->assertStatus(301)
            ->assertRedirect('/'.$creator->username.'/'.$post->id);

        $this->get('/'.$creator->username.'/'.$post->id)
            ->assertOk()
            ->assertSee('Open free content');
    }
}
