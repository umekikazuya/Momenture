<?php

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\Tag;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    public function test_タグを作成できる()
    {
        $tag = new Tag(1, 'PHP');

        $this->assertInstanceOf(Tag::class, $tag);
        $this->assertSame(1, $tag->id());
        $this->assertSame('PHP', $tag->name());
    }
}
