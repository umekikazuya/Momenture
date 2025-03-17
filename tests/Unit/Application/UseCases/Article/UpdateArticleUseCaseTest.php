<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\UseCases\Article\UpdateArticleUseCase;
use App\Domain\Entities\Article;
use App\Domain\Entities\ArticleService;
use App\Domain\Enums\ArticleStatus;
use App\Domain\Repositories\ArticleRepositoryInterface;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleTitle;
use Mockery;
use PHPUnit\Framework\TestCase;

class UpdateArticleUseCaseTest extends TestCase
{
    private $repository;

    private $useCase;

    private $article;

    protected function setUp(): void
    {
        $this->repository = Mockery::mock(ArticleRepositoryInterface::class);
        $this->useCase = new UpdateArticleUseCase($this->repository);

        $this->article = new Article(
            id: 1,
            title: new ArticleTitle('元のタイトル'),
            status: ArticleStatus::DRAFT,
            service: new ArticleService(1, 'Qiita'),
            createdAt: new \DateTimeImmutable,
            updatedAt: new \DateTimeImmutable
        );
    }

    public function test_記事を編集できる()
    {
        $newTitle = new ArticleTitle('変更後のタイトル');
        $newLink = new ArticleLink('https://updated.com');

        $this->repository
            ->shouldReceive('findById')
            ->with(1)
            ->andReturn($this->article);

        $this->repository
            ->shouldReceive('save')
            ->once();

        $updatedArticle = $this->useCase->execute(1, $newTitle, $newLink, null);

        $this->assertEquals('変更後のタイトル', $updatedArticle->title()->value());
        $this->assertEquals('https://updated.com', $updatedArticle->link()->value());
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
