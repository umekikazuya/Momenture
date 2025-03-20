<?php

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\Article;
use App\Domain\Entities\ArticleService;
use App\Domain\Entities\FeaturedArticle;
use App\Domain\Enums\ArticleStatus;
use App\Domain\ValueObjects\ArticleTitle;
use PHPUnit\Framework\TestCase;

class FeaturedArticleTest extends TestCase
{
    private FeaturedArticle $featuredArticle;

    private Article $article;

    private \DateTimeImmutable $startDate;

    private \DateTimeImmutable $endDate;

    protected function setUp(): void
    {
        $service = new ArticleService(1, 'Qiita');
        $this->article = new Article(
            id: 1,
            title: new ArticleTitle('特集記事'),
            status: ArticleStatus::PUBLISHED,
            service: $service,
            createdAt: new \DateTimeImmutable('-2 days'),
            updatedAt: new \DateTimeImmutable('-1 day')
        );

        $this->startDate = new \DateTimeImmutable('-2 days');
        $this->endDate = new \DateTimeImmutable('+3 days');

        $this->featuredArticle = new FeaturedArticle(
            id: 1,
            article: $this->article,
            startDate: $this->startDate,
            endDate: $this->endDate
        );
    }

    public function test_注目記事を作成できる()
    {
        $this->assertInstanceOf(FeaturedArticle::class, $this->featuredArticle);
        $this->assertSame(1, $this->featuredArticle->id());
        $this->assertSame($this->article, $this->featuredArticle->article());
    }

    public function test_現在の期間で注目記事かどうか判定できる()
    {
        $this->assertTrue($this->featuredArticle->isActive());
    }

    public function test_終了日が過ぎた場合は非アクティブ()
    {
        $expiredArticle = new FeaturedArticle(
            id: 2,
            article: $this->article,
            startDate: new \DateTimeImmutable('-5 days'),
            endDate: new \DateTimeImmutable('-1 day')
        );

        $this->assertFalse($expiredArticle->isActive());
    }
}
