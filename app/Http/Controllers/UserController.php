<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    use \App\Traits\Response;

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */

    public function index(): JsonResponse
    {
        $users = $this->userService->getAll();
        return $this->success($users);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->update($request->validated());
            return $this->success($user, 'User updated successfully');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $userId): JsonResponse
    {
        $user = $this->userService->findByID($userId);
        if(!$user) {
            return $this->error('User not found!', 404);
        }
        return $this->success($user);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(): JsonResponse
    {
        try {
            $this->userService->delete();
            return $this->success([], 'User deleted successfully');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
