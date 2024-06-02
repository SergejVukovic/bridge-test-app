<?php

namespace App\DTOs;

class PostDTO {
    public string $title;
    public string $content;
    public int $user_id;
    public array $tags;

    public function __construct(string $title, string $content, array $tags = [])
    {
        $this->title = $title;
        $this->content = $content;
        $this->user_id = auth()->id();
        $this->tags = $tags;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['title'],
            $data['content'],
            $data['tags'],
        );
    }

    public static function fromRequest($request): self
    {
        return new self(
            $request->input('title'),
            $request->input('content'),
            $request->input('tags'),
        );
    }
}
