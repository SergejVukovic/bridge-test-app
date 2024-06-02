<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Support\Collection;

class TagsService
{
    public Tag $tag;
    public function __construct()
    {
        $this->tag = new Tag();
    }

    public function create(array $tags_array): Collection
    {
        $tags = new Collection();
        foreach ($tags_array as $tag) {
           $dbTag = (new Tag)->firstOrNew([
                'name' => $tag,
                'slug' => $tag,
                'user_id' => auth()->id(),
            ]);
           if(!$dbTag->exists) {
               $dbTag->created_at = now();
               $dbTag->updated_at = now();
               $dbTag->save();
           }
           $tags->push($dbTag);
        }
        return $tags;
    }

    public function getTags(array $tags): array
    {
        return $this->tag->whereIn('name', $tags)->get()->toArray();
    }

}
