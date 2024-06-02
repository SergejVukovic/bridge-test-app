<?php

namespace App\Services;

use App\DTOs\CommentDTO;
use App\Models\Comment;

class CommentService
{

    private Comment $comment;

    public function __construct()
    {
        $this->comment = new Comment();
    }

    public function create(CommentDTO $commentDTO): Comment
    {
        $this->comment->content = $commentDTO->content;
        $this->comment->post_id = $commentDTO->post_id;
        $this->comment->user_id = $commentDTO->user_id;
        $this->comment->save();

        return $this->comment;
    }

    public function getAll(int $postId): array
    {
        return $this->comment->where('post_id', $postId)->get()->toArray();
    }

    public function getByID(int $commentId): Comment
    {
        return $this->comment->findOrFail($commentId);
    }

    public function update(int $commentId, CommentDTO $commentDTO): Comment
    {
        $comment = $this->comment->findOrFail($commentId);
        $comment->content = $commentDTO->content;
        $comment->post_id = $commentDTO->post_id;
        $comment->save();

        return $comment;
    }

    public function delete(int $commentId): void
    {
        $comment = $this->comment->findOrFail($commentId);
        $comment->delete();
    }

    public function canUserUpdateComment(int $commentId, int $userId): bool
    {
        $comment = $this->comment->find($commentId);

        if(!$comment) {
            return false;
        }
        if($comment->user_id !== $userId) {
            return false;
        }

        return true;
    }

}
