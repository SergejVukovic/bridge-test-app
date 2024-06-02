<?php

namespace Tests\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get('/posts');

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $post = Post::factory()->create();

        $response = $this->get('/posts/' . $post->id);

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $user = User::factory()->create();

        $postData = [
            'title' => 'Test Post',
            'content' => 'Test Content',
            'user_id' => $user->id,
            'tags' => ['tag1', 'tag2'],
        ];

        $response = $this->post('/posts', $postData);

        $response->assertStatus(201);
    }

    public function testUpdate()
    {
        $post = Post::factory()->create();

        $updatedPostData = [
            'title' => 'Updated Post',
            'content' => 'Updated Content',
            'tags' => ['tag3', 'tag4'],
        ];

        $response = $this->put('/posts/' . $post->id, $updatedPostData);

        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $post = Post::factory()->create();

        $response = $this->delete('/posts/' . $post->id);

        $response->assertStatus(204);
    }
}
