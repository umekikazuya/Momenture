<?php

namespace Tests\Unit\Application\UseCases\Article;

use App\Application\UseCases\Article\CreateArticleUseCase;
use App\Domain\Entities\Article;
use App\Domain\Entities\ArticleService;
use App\Domain\Enums\ArticleStatus;
use App\Domain\Repositories\ArticleRepositoryInterface;
use App\Domain\ValueObjects\ArticleTitle;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateArticleUseCaseTest extends TestCase
{
    private $repository;

    private $useCase;

    protected function setUp(): void
    {
        $this->repository = Mockery::mock(ArticleRepositoryInterface::class);
        $this->useCase = new CreateArticleUseCase($this->repository);
    }

    public function test_記事を作成できる()
    {
        $title = new ArticleTitle('テスト記事');
        $status = ArticleStatus::DRAFT;
        $service = new ArticleService(1, 'Qiita');

        $this->repository
            ->shouldReceive('save')
            ->once()
            ->with(Mockery::type(Article::class));

        $article = $this->useCase->execute($title->value(), $status, $service);

        $this->assertInstanceOf(Article::class, $article);
        $this->assertEquals('テスト記事', $article->title()->value());
        $this->assertEquals(ArticleStatus::DRAFT, $article->status());
        $this->assertEquals('Qiita', $article->service()->name());
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
