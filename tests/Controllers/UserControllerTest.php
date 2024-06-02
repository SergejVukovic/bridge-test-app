<?php

namespace Tests\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get('/users');

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $user = User::factory()->create();

        $response = $this->get('/users/' . $user->id);

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->post('/users', $userData);

        $response->assertStatus(201);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();

        $updatedUserData = [
            'name' => 'Updated User',
            'email' => 'updated@example.com',
        ];

        $response = $this->put('/users/' . $user->id, $updatedUserData);

        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();

        $response = $this->delete('/users/' . $user->id);

        $response->assertStatus(204);
    }
}
