<?php

namespace Tests\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $post = Post::factory()->create();

        $response = $this->get('/posts/' . $post->id . '/comments');

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $comment = Comment::factory()->create();

        $response = $this->get('/comments/' . $comment->id);

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $commentData = [
            'content' => 'Test Comment',
            'post_id' => $post->id,
            'user_id' => $user->id,
        ];

        $response = $this->post('/comments', $commentData);

        $response->assertStatus(201);
    }

    public function testUpdate()
    {
        $comment = Comment::factory()->create();

        $updatedCommentData = [
            'content' => 'Updated Comment',
        ];

        $response = $this->put('/comments/' . $comment->id, $updatedCommentData);

        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $comment = Comment::factory()->create();

        $response = $this->delete('/comments/' . $comment->id);

        $response->assertStatus(204);
    }
}
