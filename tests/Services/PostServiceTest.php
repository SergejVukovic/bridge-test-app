<?php

namespace Tests\Services;

use App\Services\PostService;
use App\DTOs\PostDTO;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class PostServiceTest extends TestCase
{
    use RefreshDatabase;

    private $postService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->postService = app(PostService::class);
    }

    public function testCreate()
    {
        $postDTO = new PostDTO();
        $postDTO->title = 'Test Title';
        $postDTO->content = 'Test Content';
        $postDTO->user_id = 1;
        $postDTO->tags = ['tag1', 'tag2'];

        $post = $this->postService->create($postDTO);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('Test Title', $post->title);
        $this->assertEquals('Test Content', $post->content);
        $this->assertEquals(1, $post->user_id);
    }

    public function testGetAll()
    {
        $posts = $this->postService->getAll();

        $this->assertIsArray($posts);
    }

    public function testGetByID()
    {
        $post = $this->postService->getByID(1);

        $this->assertInstanceOf(Post::class, $post);
    }

    public function testUpdate()
    {
        $postDTO = new PostDTO();
        $postDTO->title = 'Updated Title';
        $postDTO->content = 'Updated Content';
        $postDTO->tags = ['tag3', 'tag4'];

        $post = $this->postService->update(1, $postDTO);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('Updated Title', $post->title);
        $this->assertEquals('Updated Content', $post->content);
    }

    public function testDelete()
    {
        $this->postService->delete(1);
    }

    public function testCanUserUpdatePost()
    {
        $canUpdate = $this->postService->canUserUpdatePost(1, 1);

        $this->assertTrue($canUpdate);
    }
}
