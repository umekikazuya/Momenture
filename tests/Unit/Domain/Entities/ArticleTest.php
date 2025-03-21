<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\Article;
use App\Domain\Entities\ArticleService;
use App\Domain\Enums\ArticleStatus;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;
use App\Domain\ValueObjects\ArticleTitle;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    private Article $article;

    private ArticleService $service;

    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable $updatedAt;

    protected function setUp(): void
    {
        $this->service = new ArticleService(new ArticleServiceId(1), new ArticleServiceName('Qiita'));
        $this->createdAt = new \DateTimeImmutable('-1 day', new \DateTimeZone('UTC'));
        $this->updatedAt = new \DateTimeImmutable('-1 hour');

        $this->article = new Article(
            id: 1,
            title: new ArticleTitle('テスト記事'),
            status: ArticleStatus::DRAFT,
            service: $this->service,
            createdAt: $this->createdAt,
            updatedAt: $this->updatedAt,
            link: new ArticleLink('https://example.com')
        );
    }

    public function test_記事を作成できる()
    {
        $this->assertInstanceOf(Article::class, $this->article);
        $this->assertSame(1, $this->article->id());
        $this->assertSame('テスト記事', $this->article->title()->value());
        $this->assertSame(ArticleStatus::DRAFT, $this->article->status());
        $this->assertSame('Qiita', $this->article->service()->name()->value());
        $this->assertSame('https://example.com', $this->article->link()->value());
        $this->assertEquals($this->createdAt, $this->article->createdAt());
        $this->assertEquals($this->updatedAt, $this->article->updatedAt());
    }

    public function test_タイトルを更新できる()
    {
        $oldUpdatedAt = $this->article->updatedAt();
        // 時間の経過を確実にするため少し待機
        usleep(1000);
        $newTitle = new ArticleTitle('更新後のタイトル');
        $this->article->updateTitle($newTitle);

        $this->assertSame('更新後のタイトル', $this->article->title()->value());
        $this->assertGreaterThan($oldUpdatedAt, $this->article->updatedAt(), '更新日時が正しく更新されていません');
    }

    public function test_リンクを更新できる()
    {
        $newLink = new ArticleLink('https://updated.com');
        $this->article->updateLink($newLink);

        $this->assertSame('https://updated.com', $this->article->link()->value());
    }

    public function test_リンクを削除できる()
    {
        $this->article->updateLink(null);

        $this->assertNull($this->article->link());
    }

    public function test_記事を公開できる()
    {
        $this->article->publish();

        $this->assertTrue($this->article->isPublished());
    }

    public function test_公開済みの記事は再度公開できない()
    {
        $this->article->publish();

        $this->expectException(\DomainException::class);
        $this->article->publish();
    }

    public function test_記事の状態を判定できる()
    {
        $this->assertTrue($this->article->isDraft());
        $this->assertFalse($this->article->isPublished());

        $this->article->publish();
        $this->assertTrue($this->article->isPublished());
        $this->assertFalse($this->article->isDraft());
    }
}
