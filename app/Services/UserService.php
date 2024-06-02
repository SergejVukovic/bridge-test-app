<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    private User | null $current_user;

    public function __construct()
    {
        $this->user = new User();
        $this->current_user = auth()->user();
    }

    public function create(UserDTO $data): User
    {
        $this->user->name = $data->name;
        $this->user->email = $data->email;
        $this->user->password = $data->password;
        $this->user->save();
        return $this->user;
    }

    public function findByID(int $id): User|null
    {
        return $this->user->find($id);
    }

    public function findByEmail(string $email): User|null
    {
        return $this->user->whereEmail($email)->first();
    }

    public function update($user_data): User
    {
        $this->current_user->updateOrFail($user_data);
        return $this->current_user;
    }

    public function delete(): bool
    {
        return $this->current_user->delete();
    }

    public function getAll(): Collection
    {
        return $this->user->all();
    }

    public function login(UserDTO $user_data): ?string
    {
        $user = $this->findByEmail($user_data->email);
        if(!$user) {
            throw new \Exception('User not found');
        }
        return $user->createToken('authToken')->plainTextToken;
    }
}
