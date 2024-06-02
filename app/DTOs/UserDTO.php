<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class UserDTO
{
    public ?string $name;
    public ?string $email;
    public ?string $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['email'],
            $data['password']
        );
    }

    public static function fromPartialArray(array $data): self
    {
        return new self(
            $data['name'] ?? null,
            $data['email'] ?? null,
            $data['password'] ?? null
        );
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );
    }

    public static function fromCredentials(Request $request): self
    {
        return new self(
            '',
            $request->input('email'),
            $request->input('password')
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ];
    }

}
