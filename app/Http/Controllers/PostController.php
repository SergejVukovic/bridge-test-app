<?php

namespace App\Http\Controllers;

use App\DTOs\PostDTO;
use App\Http\Requests\Post\CreateRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    use \App\Traits\Response;
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $posts = $this->postService->getAll();
        return $this->success($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request): JsonResponse
    {
        $postDTO = PostDTO::fromRequest($request);
        $post = $this->postService->create($postDTO);
        return $this->success($post, 'Post created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $postId): JsonResponse
    {
        $post = $this->postService->getByID($postId);
        return $this->success($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, int $postId): JsonResponse
    {
        $postDTO = PostDTO::fromRequest($request);
        $updatedPost = $this->postService->update($postId, $postDTO);
        return $this->success($updatedPost, 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $postId): JsonResponse
    {
        $this->postService->delete($postId);
        return $this->success(null, 'Post deleted successfully');
    }
}
