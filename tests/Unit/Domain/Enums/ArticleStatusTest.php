<?php

namespace Tests\Unit\Domain\Enums;

use App\Domain\Enums\ArticleStatus;
use PHPUnit\Framework\TestCase;

class ArticleStatusTest extends TestCase
{
    public function test_公開可能な状態を判定できる()
    {
        $this->assertTrue(ArticleStatus::DRAFT->canBePublished());
        $this->assertFalse(ArticleStatus::PUBLISHED->canBePublished());
        $this->assertFalse(ArticleStatus::ARCHIVED->canBePublished());
    }

    public function test_無効なステータスを作成できない()
    {
        $this->expectException(\ValueError::class);
    }
}
