<?php

namespace App\Services;

use App\DTOs\PostDTO;
use App\Models\Post;

class PostService
{

    private Post $post;

    public function __construct()
    {
        $this->post = new Post();
    }

    public function create(PostDTO $postDTO): Post
    {
        $this->post->title = $postDTO->title;
        $this->post->content = $postDTO->content;
        $this->post->user_id = $postDTO->user_id;
        $this->post->save();

        if($postDTO->tags) {
            $this->syncTags($this->post, $postDTO->tags);
        }

        return $this->post;
    }

    public function getAll(): array
    {
        return $this->post->all()->toArray();
    }

    public function getByID(int $id): ?Post
    {
        return $this->post->find($id);
    }

    public function update(int $id, PostDTO $postDTO): Post
    {
        $post = $this->getByID($id);
        if (!$post) {
            throw new \Exception('Post not found');
        }

        $post->title = $postDTO->title;
        $post->content = $postDTO->content;
        $post->save();

        if($postDTO->tags) {
            $this->syncTags($post, $postDTO->tags);
        }

        return $post;
    }

    public function delete(int $id): void
    {
        $post = $this->getByID($id);
        if (!$post) {
            throw new \Exception('Post not found');
        }

        $post->delete();
    }

    private function syncTags(Post $post, array $tags_array): Post
    {
        $tags = (new TagsService)->create($tags_array);
        $post->tags()->sync($tags->pluck('id')->toArray());
        $post->refresh();
        return $post;
    }

    public function canUserUpdatePost(int $postId, int $userId): bool
    {
        $post = $this->getByID($postId);
        if (!$post) {
            return false;
        }
        if ($post->user_id !== $userId) {
            return false;
        }
        return true;
    }

}
