<?php

namespace App\Http\Controllers;

use App\DTOs\CommentDTO;
use App\Http\Requests\Comment\CreateRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{

    use \App\Traits\Response;
    private CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index($postId): JsonResponse
    {
        $comments = $this->commentService->getAll($postId);
        return $this->success($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request): JsonResponse
    {
        $commentDTO = CommentDTO::fromRequest($request);
        $comment = $this->commentService->create($commentDTO);
        return $this->success($comment, 'Comment created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $commentId): JsonResponse
    {
        $comment = $this->commentService->getByID($commentId);
        return $this->success($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request): JsonResponse
    {
        $commentDTO = CommentDTO::fromRequest($request);
        $updatedComment = $this->commentService->update($request->route('comment_id'), $commentDTO);
        return $this->success($updatedComment, 'Comment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $commentId): JsonResponse
    {
        $this->commentService->delete($commentId);
        return $this->success(null, 'Comment deleted successfully');
    }
}
