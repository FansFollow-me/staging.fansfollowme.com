<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Post;
use App\Models\PpvPurchase;
use App\Models\Subscription;
use App\Models\User;
use App\Support\UploadStorage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreatorPostMediaAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('s3');
        config([
            'ffm.upload_disk' => 's3',
            'filesystems.disks.s3.url' => null,
        ]);
    }

    private function makeCreator(string $username = 'coach'): User
    {
        $creator = User::factory()->create(['role' => UserRole::Creator, 'username' => $username]);
        $creator->profile()->create(['display_name' => 'Coach']);
        $creator->wallet()->create(['balance' => 0, 'currency' => 'USD']);
        $creator->creatorSettings()->create([
            'subscription_price' => 1499,
            'currency' => 'USD',
            'accepts_subscriptions' => true,
        ]);

        return $creator;
    }

    private function makeFan(string $username, float $balance = 10000): User
    {
        $fan = User::factory()->create(['role' => UserRole::Fan, 'username' => $username]);
        $fan->profile()->create(['display_name' => $username]);
        $fan->wallet()->create(['balance' => (int) $balance, 'currency' => 'USD']);

        return $fan;
    }

    private function publishPhoto(User $creator, bool $paid, int $price = 499): Post
    {
        $this->actingAs($creator)
            ->post('/my/posts', [
                'body' => $paid ? 'Locked drop' : 'Free photo drop',
                'type' => 'photo',
                'access' => $paid ? 'ppv' : 'free',
                'price' => $paid ? (string) $price : '0',
                'media' => UploadedFile::fake()->create('shot.jpg', 120, 'image/jpeg'),
            ])
            ->assertRedirect('/my/posts');

        return Post::where('creator_id', $creator->id)->latest('id')->firstOrFail();
    }

    public function test_free_and_paid_photo_posts_appear_on_profile_permalink(): void
    {
        $creator = $this->makeCreator('coach1');
        $free = $this->publishPhoto($creator, false);
        $paid = $this->publishPhoto($creator, true, 499);

        $this->assertTrue(Storage::disk('s3')->exists(UploadStorage::normalize($free->media->first()->path)));
        $this->assertTrue(Storage::disk('s3')->exists(UploadStorage::normalize($paid->media->first()->path)));

        $this->get('/'.$creator->username.'/'.$free->id)->assertOk();
        $this->get('/'.$creator->username.'/'.$paid->id)->assertOk();
    }

    public function test_paid_post_media_is_hidden_from_guests_and_non_subscribers(): void
    {
        $creator = $this->makeCreator('coach2');
        $paid = $this->publishPhoto($creator, true, 499);
        $media = $paid->media()->first();

        $guestPage = $this->get('/'.$creator->username.'/'.$paid->id);
        $guestPage->assertOk();
        $guestPage->assertDontSee($media->url(), false);

        $mediaRoute = '/media/posts/'.$media->id;
        $this->get($mediaRoute)->assertForbidden();

        $otherFan = $this->makeFan('stranger');
        $this->actingAs($otherFan)->get($mediaRoute)->assertForbidden();
    }

    public function test_ppv_media_ok_for_owner_and_buyer_not_subscriber(): void
    {
        $creator = $this->makeCreator('coach3');
        $paid = $this->publishPhoto($creator, true, 499);
        $media = $paid->media()->first();
        $mediaRoute = '/media/posts/'.$media->id;

        // Owner
        $this->actingAs($creator)->get($mediaRoute)->assertOk();

        // Subscriber without PPV purchase must NOT see PPV media
        $subscriber = $this->makeFan('subscriber1');
        Subscription::create([
            'fan_id' => $subscriber->id,
            'creator_id' => $creator->id,
            'status' => 'active',
            'price' => 1499,
            'currency' => 'USD',
            'provider' => 'wallet',
            'started_at' => now(),
            'ends_at' => now()->addMonth(),
        ]);
        $this->actingAs($subscriber)->get($mediaRoute)->assertForbidden();

        // PPV buyer
        $buyer = $this->makeFan('ppvbuyer1', 2000);
        $this->actingAs($buyer)
            ->post('/posts/'.$paid->id.'/unlock')
            ->assertRedirect();
        $this->assertDatabaseHas('ppv_purchases', [
            'user_id' => $buyer->id,
            'post_id' => $paid->id,
        ]);
        $this->actingAs($buyer)->get($mediaRoute)->assertOk();
    }

    public function test_public_media_route_allowlist_blocks_post_prefix(): void
    {
        $creator = $this->makeCreator('coach4');
        $paid = $this->publishPhoto($creator, true, 499);
        $path = UploadStorage::normalize($paid->media->first()->path);

        // Even if someone crafts a public /media/ URL for posts/, it must 404
        $this->get('/media/'.$path)->assertNotFound();
    }
}
