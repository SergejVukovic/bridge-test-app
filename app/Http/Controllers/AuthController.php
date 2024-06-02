<?php

namespace App\Http\Controllers;

use App\DTOs\UserDTO;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use \App\Traits\Response;
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function register(RegisterRequest $request): JsonResponse
    {
        $user_data = UserDTO::fromRequest($request);
        try {
            $new_user = $this->userService->create($user_data);
            return $this->success([
                'user' => $new_user,
                'token' => $new_user->getToken(),
            ], 'User created successfully', Response::HTTP_CREATED);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user_data = UserDTO::fromCredentials($request);
        try {
            $token = $this->userService->login($user_data);
            return $this->success([
                'token' => $token,
            ], 'User logged in successfully');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
