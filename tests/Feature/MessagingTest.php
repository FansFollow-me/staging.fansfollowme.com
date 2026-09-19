<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessagingTest extends TestCase
{
    use RefreshDatabase;

    private function user(UserRole $role = UserRole::Fan): User
    {
        $u = User::factory()->create([
            'role' => $role,
            'username' => 'msg'.uniqid(),
        ]);
        $u->profile()->create(['display_name' => 'Msg']);
        $u->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        return $u;
    }

    public function test_user_can_start_conversation_and_send_message(): void
    {
        $fan = $this->user();
        $creator = $this->user(UserRole::Creator);

        $this->actingAs($fan)
            ->post('/messages/start/'.$creator->id)
            ->assertRedirect();

        $conversation = Conversation::first();
        $this->assertNotNull($conversation);

        $this->actingAs($fan)->post('/messages/'.$conversation->id, [
            'body' => 'Hey coach',
        ])->assertRedirect('/messages/'.$conversation->id);

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'user_id' => $fan->id,
            'body' => 'Hey coach',
        ]);
    }

    public function test_non_participant_cannot_read_conversation(): void
    {
        $a = $this->user();
        $b = $this->user();
        $c = $this->user();

        $conversation = Conversation::findOrCreateBetween($a->id, $b->id);

        $this->actingAs($c)->get('/messages/'.$conversation->id)->assertForbidden();
    }

    public function test_find_or_create_reuses_same_pair(): void
    {
        $a = $this->user();
        $b = $this->user();

        $c1 = Conversation::findOrCreateBetween($a->id, $b->id);
        $c2 = Conversation::findOrCreateBetween($b->id, $a->id);

        $this->assertSame($c1->id, $c2->id);
        $this->assertSame(1, Conversation::count());
    }

    public function test_inbox_lists_conversation(): void
    {
        $fan = $this->user();
        $creator = $this->user(UserRole::Creator);
        $conv = Conversation::findOrCreateBetween($fan->id, $creator->id);
        Message::create([
            'conversation_id' => $conv->id,
            'user_id' => $creator->id,
            'body' => 'Welcome',
        ]);

        $this->actingAs($fan)->get('/messages')->assertOk()->assertSee('Welcome');
    }
}
