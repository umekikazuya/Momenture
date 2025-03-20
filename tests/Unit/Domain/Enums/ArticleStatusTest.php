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
    }

    public function test_無効なステータスを作成できない()
    {
        $this->expectException(\ValueError::class);
        // 無効なステータスで ArticleStatus を作成する試み
        ArticleStatus::from('invalid_status');
    }

    public function test_全てのステータスが取得できる()
    {
        $statuses = ArticleStatus::cases();
        $this->assertCount(2, $statuses);
        $this->assertContains(ArticleStatus::DRAFT, $statuses);
        $this->assertContains(ArticleStatus::PUBLISHED, $statuses);
    }

    public function test_ステータスの値が正しい()
    {
        $this->assertEquals('draft', ArticleStatus::DRAFT->value);
        $this->assertEquals('published', ArticleStatus::PUBLISHED->value);
    }
}
