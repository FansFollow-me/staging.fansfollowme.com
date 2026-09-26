<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Post;
use App\Models\User;
use App\Support\ImageUpload;
use App\Support\UploadStorage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageUploadTest extends TestCase
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

    private function makeCreator(string $username = 'imgcoach'): User
    {
        $creator = User::factory()->create(['role' => UserRole::Creator, 'username' => $username]);
        $creator->profile()->create(['display_name' => 'Img']);
        $creator->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        return $creator;
    }

    public function test_avatar_is_resized_and_stored_as_jpeg(): void
    {
        $creator = $this->makeCreator();
        $img = UploadedFile::fake()->image('big.jpg', 2000, 1600, 'jpeg');

        $this->actingAs($creator)
            ->put('/settings/page', [
                'display_name' => 'Img',
                'avatar' => $img,
            ])
            ->assertSessionHas('status');

        $path = UploadStorage::normalize((string) $creator->fresh()->profile->avatar_path);
        $this->assertStringStartsWith('profiles/', $path);
        $this->assertStringEndsWith('.jpg', $path);
        Storage::disk('s3')->assertExists($path);

        $size = getimagesizefromstring(Storage::disk('s3')->get($path));
        $this->assertNotFalse($size);
        $this->assertLessThanOrEqual(800, $size[0]);
        $this->assertLessThanOrEqual(800, $size[1]);
    }

    public function test_cover_resizes_to_max_2400_wide(): void
    {
        $creator = $this->makeCreator('imgcoach2');
        $img = UploadedFile::fake()->image('wide.png', 4000, 1000, 'png');

        $this->actingAs($creator)
            ->put('/settings/page', [
                'display_name' => 'Img',
                'cover' => $img,
            ])
            ->assertSessionHas('status');

        $path = UploadStorage::normalize((string) $creator->fresh()->profile->cover_path);
        Storage::disk('s3')->assertExists($path);
        $size = getimagesizefromstring(Storage::disk('s3')->get($path));
        $this->assertLessThanOrEqual(2400, $size[0]);
    }

    public function test_post_photo_resizes_to_2048_and_strips_exif_by_reencode(): void
    {
        $creator = $this->makeCreator('imgcoach3');
        $img = UploadedFile::fake()->image('shot.jpg', 4000, 3000, 'jpeg');

        $this->actingAs($creator)
            ->post('/my/posts', [
                'body' => 'Photo drop',
                'type' => 'photo',
                'access' => 'free',
                'media' => $img,
            ])
            ->assertRedirect('/my/posts');

        $post = Post::where('creator_id', $creator->id)->latest('id')->firstOrFail();
        $path = UploadStorage::normalize((string) $post->media->first()->path);
        Storage::disk('s3')->assertExists($path);

        $bytes = Storage::disk('s3')->get($path);
        $size = getimagesizefromstring($bytes);
        $this->assertLessThanOrEqual(2048, max($size[0], $size[1]));

        // Re-encoded JPEG has no GPS EXIF segment
        $this->assertFalse(stripos(bin2hex(substr($bytes, 0, 64)), 'gps') !== false);
        $this->assertStringNotContainsString('GPS', (string) $bytes);
    }

    public function test_validation_rejects_over_20mb(): void
    {
        $creator = $this->makeCreator('imgcoach4');

        $this->actingAs($creator)
            ->put('/settings/page', [
                'display_name' => 'Img',
                'avatar' => UploadedFile::fake()->create('b.jpg', 20481, 'image/jpeg'),
            ])
            ->assertSessionHasErrors('avatar');
    }

    public function test_under_20mb_image_accepted(): void
    {
        $creator = $this->makeCreator('imgcoach4b');
        $img = UploadedFile::fake()->image('ok.jpg', 1200, 1200, 'jpeg');

        $this->actingAs($creator)
            ->put('/settings/page', [
                'display_name' => 'Img',
                'avatar' => $img,
            ])
            ->assertSessionHas('status');
    }

    public function test_php_dropped_upload_shows_clear_error(): void
    {
        $creator = $this->makeCreator('imgcoach5');
        $file = new UploadedFile(
            (new \SplFileInfo(__FILE__))->getPathname(),
            'huge.jpg',
            'image/jpeg',
            UPLOAD_ERR_INI_SIZE,
            true
        );

        $this->assertTrue(ImageUpload::hasFailedUpload($file));
        $this->assertStringContainsString('too large for the server', ImageUpload::uploadErrorMessage($file));
    }

    public function test_heic_without_support_shows_clear_message(): void
    {
        // Fake a HEIC-ish name; process() should fail with a clear message when unsupported
        $tmp = tempnam(sys_get_temp_dir(), 'heic');
        file_put_contents($tmp, 'not-an-image');
        $file = new UploadedFile($tmp, 'shot.heic', 'image/heic', null, true);

        if (ImageUpload::heicSupported()) {
            $this->markTestSkipped('HEIC is supported on this runtime');
        }

        try {
            ImageUpload::process($file, ImageUpload::KIND_POST);
            $this->fail('Expected HEIC rejection');
        } catch (\RuntimeException $e) {
            $this->assertStringContainsString('JPG', $e->getMessage());
        }
    }
}
