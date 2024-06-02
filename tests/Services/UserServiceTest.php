<?php

namespace Tests\Services;

use App\Services\UserService;
use App\DTOs\UserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;

    public function setUp(): void
    {
        parent::setUp();
        $this->userService = app(UserService::class);
    }

    public function testCreate()
    {
        $userDTO = UserDTO::fromArray([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $user = $this->userService->create($userDTO);

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertNotNull($user->password);
    }

    public function testFindByID()
    {
        $user = $this->userService->create(UserDTO::fromArray([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]));

        $foundUser = $this->userService->findByID($user->id);

        $this->assertEquals($user->id, $foundUser->id);
    }

    public function testFindByEmail()
    {
        $user = $this->userService->create(UserDTO::fromArray([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]));

        $foundUser = $this->userService->findByEmail($user->email);

        $this->assertEquals($user->email, $foundUser->email);
    }

    public function testUpdate()
    {
        $user = $this->userService->create(UserDTO::fromArray([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]));

        $updatedUser = $this->userService->update(['name' => 'Updated Name']);

        $this->assertEquals('Updated Name', $updatedUser->name);
    }

    public function testDelete()
    {
        $user = $this->userService->create(UserDTO::fromArray([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]));

        $this->userService->delete();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function testGetAll()
    {
        $user1 = $this->userService->create(UserDTO::fromArray([
            'name' => 'Test User 1',
            'email' => 'test1@example.com',
            'password' => 'password',
        ]));

        $user2 = $this->userService->create(UserDTO::fromArray([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'password' => 'password',
        ]));

        $users = $this->userService->getAll();

        $this->assertCount(2, $users);
        $this->assertEquals($user1->id, $users[0]->id);
        $this->assertEquals($user2->id, $users[1]->id);
    }

    public function testLogin()
    {
        $user = $this->userService->create(UserDTO::fromArray([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]));

        $token = $this->userService->login(UserDTO::fromArray([
            'email' => 'test@example.com',
            'password' => 'password',
        ]));

        $this->assertNotNull($token);
    }
}
