<?php

namespace Tests\Services;

use App\Services\TagsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class TagsServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $tagsService;

    public function setUp(): void
    {
        parent::setUp();
        $this->tagsService = app(TagsService::class);
    }

    public function testCreate()
    {
        $tagsArray = ['tag1', 'tag2', 'tag3'];

        $tags = $this->tagsService->create($tagsArray);

        $this->assertCount(3, $tags);
        $this->assertEquals('tag1', $tags[0]->name);
        $this->assertEquals('tag2', $tags[1]->name);
        $this->assertEquals('tag3', $tags[2]->name);
    }

    public function testGetTags()
    {
        $tagsArray = ['tag1', 'tag2', 'tag3'];

        $this->tagsService->create($tagsArray);

        $tags = $this->tagsService->getTags($tagsArray);

        $this->assertCount(3, $tags);
        $this->assertEquals('tag1', $tags[0]['name']);
        $this->assertEquals('tag2', $tags[1]['name']);
        $this->assertEquals('tag3', $tags[2]['name']);
    }
}
