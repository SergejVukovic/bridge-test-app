<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class CommentDTO {
    public string $content;
    public int $post_id;
    public int $user_id;

    public function __construct(string $content, int $post_id)
    {
        $this->content = $content;
        $this->post_id = $post_id;
        $this->user_id = auth()->id();
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['content'],
            $data['post_id'],
        );
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('content'),
            $request->route('post_id'),
        );
    }
}
