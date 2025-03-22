<?php

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\Article;
use App\Domain\Entities\ArticleService;
use App\Domain\Entities\FeaturedArticle;
use App\Domain\Enums\ArticleStatus;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;
use App\Domain\ValueObjects\ArticleTitle;
use App\Domain\ValueObjects\FeaturedArticleId;
use App\Domain\ValueObjects\FeaturedPriority;
use PHPUnit\Framework\TestCase;

class FeaturedArticleTest extends TestCase
{
    private FeaturedArticle $featuredArticle;

    private Article $article;

    protected function setUp(): void
    {
        $service = new ArticleService(new ArticleServiceId(1), new ArticleServiceName('Qiita'));
        $this->article = new Article(
            id: 1,
            title: new ArticleTitle('特集記事'),
            status: ArticleStatus::PUBLISHED,
            service: $service,
            createdAt: new \DateTimeImmutable('-2 days'),
            updatedAt: new \DateTimeImmutable('-1 day')
        );

        $this->featuredArticle = new FeaturedArticle(
            id: new FeaturedArticleId(1),
            article: $this->article,
            priority: new FeaturedPriority(1),
            isActive: true,
            createdAt: new \DateTimeImmutable('-1 day'),
        );
    }

    public function test_注目記事を作成できる()
    {
        $this->assertInstanceOf(FeaturedArticle::class, $this->featuredArticle);
        $this->assertSame(1, $this->featuredArticle->id()->value());
        $this->assertSame($this->article, $this->featuredArticle->article());
    }
}
