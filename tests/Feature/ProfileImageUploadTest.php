<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use App\Support\UploadStorage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileImageUploadTest extends TestCase
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

    private function makeCreator(string $username = 'viking'): User
    {
        $creator = User::factory()->create([
            'role' => UserRole::Creator,
            'username' => $username,
        ]);
        $creator->profile()->create(['display_name' => 'Viking']);
        $creator->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        return $creator;
    }

    public function test_avatar_and_cover_upload_saves_to_s3_and_shows_on_profile(): void
    {
        $creator = $this->makeCreator();

        $this->actingAs($creator)
            ->put('/settings/page', [
                'display_name' => 'David Kurzhal',
                'bio' => 'Founder bio',
                'avatar' => UploadedFile::fake()->create('avatar.jpg', 200, 'image/jpeg'),
                'cover' => UploadedFile::fake()->create('cover.jpg', 400, 'image/jpeg'),
            ])
            ->assertSessionHas('status');

        $profile = $creator->fresh()->profile;

        $this->assertNotNull($profile->avatar_path);
        $this->assertNotNull($profile->cover_path);
        $this->assertStringStartsWith('profiles/', UploadStorage::normalize($profile->avatar_path));
        $this->assertStringStartsWith('profiles/', UploadStorage::normalize($profile->cover_path));

        Storage::disk('s3')->assertExists(UploadStorage::normalize($profile->avatar_path));
        Storage::disk('s3')->assertExists(UploadStorage::normalize($profile->cover_path));

        $page = $this->get('/'.$creator->username);
        $page->assertOk();
        $page->assertSee(UploadStorage::normalize($profile->avatar_path), false);
        $page->assertSee(UploadStorage::normalize($profile->cover_path), false);
    }

    public function test_invalid_avatar_type_is_rejected(): void
    {
        $creator = $this->makeCreator('viking2');

        $this->actingAs($creator)
            ->put('/settings/page', [
                'display_name' => 'David Kurzhal',
                'avatar' => UploadedFile::fake()->create('evil.php', 20, 'text/plain'),
            ])
            ->assertSessionHasErrors('avatar');
    }

    public function test_oversize_avatar_is_rejected(): void
    {
        $creator = $this->makeCreator('viking3');

        $this->actingAs($creator)
            ->put('/settings/page', [
                'display_name' => 'David Kurzhal',
                'avatar' => UploadedFile::fake()->create('big.jpg', 20481, 'image/jpeg'),
            ])
            ->assertSessionHasErrors('avatar');
    }
}
