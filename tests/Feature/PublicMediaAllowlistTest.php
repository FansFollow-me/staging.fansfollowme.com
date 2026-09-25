<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicMediaAllowlistTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('s3');
        config([
            'ffm.upload_disk' => 's3',
            'filesystems.disks.s3.url' => null,
        ]);
    }

    private function putPublic(string $path): void
    {
        Storage::disk('s3')->put($path, 'fake-bytes');
    }

    public function test_public_avatar_path_returns_200(): void
    {
        $this->putPublic('profiles/avatar-test.jpg');

        $this->get('/media/profiles/avatar-test.jpg')->assertOk();
    }

    public function test_public_story_and_reel_paths_return_200(): void
    {
        $this->putPublic('stories/story-test.jpg');
        $this->putPublic('reels/reel-test.mp4');
        $this->putPublic('reels/thumbs/thumb-test.jpg');

        $this->get('/media/stories/story-test.jpg')->assertOk();
        $this->get('/media/reels/reel-test.mp4')->assertOk();
        $this->get('/media/reels/thumbs/thumb-test.jpg')->assertOk();
    }

    public function test_private_prefixes_return_404_even_if_object_exists(): void
    {
        foreach ([
            'posts/secret.jpg',
            'vault/1/secret.pdf',
            'products/secret.zip',
            'video-messages/1/secret.mp4',
        ] as $path) {
            $this->putPublic($path);
            $this->get('/media/'.$path)->assertNotFound();
        }
    }

    public function test_other_prefixes_return_404(): void
    {
        $this->putPublic('img/should-not-serve.png');
        $this->putPublic('other/secret.png');

        $this->get('/media/img/should-not-serve.png')->assertNotFound();
        $this->get('/media/other/secret.png')->assertNotFound();
    }

    public function test_traversal_and_encoded_traversal_return_404(): void
    {
        $this->putPublic('profiles/ok.jpg');

        $this->get('/media/../.env')->assertNotFound();
        $this->get('/media/..%2f.env')->assertNotFound();
        $this->get('/media/%2e%2e/.env')->assertNotFound();
        $this->get('/media/%2e%2e/%2e%2e/.env')->assertNotFound();
        $this->get('/media/profiles/../../.env')->assertNotFound();
        $this->get('/media/profiles/..%5c..%5c.env')->assertNotFound();
        $this->get('/media/\\windows\\system32')->assertNotFound();
        $this->get('/media/%00profiles/ok.jpg')->assertNotFound();
    }

    public function test_absolute_and_double_slash_paths_are_not_served(): void
    {
        $this->putPublic('profiles/ok.jpg');

        $this->get('/media//etc/passwd')->assertNotFound();
        $this->get('/media/%2fetc%2fpasswd')->assertNotFound();
    }
}
