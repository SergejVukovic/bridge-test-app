<?php

namespace Tests\Services;

use App\Services\CommentService;
use App\DTOs\CommentDTO;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class CommentServiceTest extends TestCase
{
    use RefreshDatabase;

    private $commentService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->commentService = app(CommentService::class);
    }

    public function testCreate()
    {
        $commentDTO = new CommentDTO();
        $commentDTO->content = 'Test Comment';
        $commentDTO->post_id = 1;
        $commentDTO->user_id = 1;

        $comment = $this->commentService->create($commentDTO);

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals('Test Comment', $comment->content);
        $this->assertEquals(1, $comment->post_id);
        $this->assertEquals(1, $comment->user_id);
    }

    public function testGetAll()
    {
        $comments = $this->commentService->getAll(1);

        $this->assertIsArray($comments);
    }

    public function testGetByID()
    {
        $comment = $this->commentService->getByID(1);

        $this->assertInstanceOf(Comment::class, $comment);
    }

    public function testUpdate()
    {
        $commentDTO = new CommentDTO();
        $commentDTO->content = 'Updated Comment';
        $commentDTO->post_id = 1;
        $commentDTO->user_id = 1;

        $comment = $this->commentService->update(1, $commentDTO);

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals('Updated Comment', $comment->content);
    }

    public function testDelete()
    {
        $this->commentService->delete(1);
    }

    public function testCanUserUpdateComment()
    {
        $canUpdate = $this->commentService->canUserUpdateComment(1, 1);

        $this->assertTrue($canUpdate);
    }
}
