<?php

namespace Tests\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegister()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->post('/register', $userData);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'email',
                ],
                'token',
            ],
            'message',
        ]);
    }

    public function testLogin()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password'),
        ]);

        $loginData = [
            'email' => $user->email,
            'password' => $password,
        ];

        $response = $this->post('/login', $loginData);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'token',
            ],
            'message',
        ]);
    }
}
