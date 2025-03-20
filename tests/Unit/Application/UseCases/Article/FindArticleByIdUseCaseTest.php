<?php

namespace Tests\Unit\Application\UseCases\Article;

use App\Application\UseCases\Article\FindArticleByIdUseCase;
use App\Domain\Entities\Article;
use App\Domain\Repositories\ArticleRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class FindArticleByIdUseCaseTest extends TestCase
{
    private $repository;

    private $useCase;

    private $article;

    protected function setUp(): void
    {
        $this->repository = Mockery::mock(ArticleRepositoryInterface::class);
        $this->useCase = new FindArticleByIdUseCase($this->repository);

        $this->article = Mockery::mock(Article::class);
    }

    public function test_記事を取得できる()
    {
        $this->repository
            ->shouldReceive('findById')
            ->with(1)
            ->andReturn($this->article);

        $result = $this->useCase->execute(1);

        $this->assertSame($this->article, $result);
    }

    public function test_存在しない記事なら_nullを返す()
    {
        $this->repository
            ->shouldReceive('findById')
            ->with(99)
            ->andReturn(null);

        $result = $this->useCase->execute(99);

        $this->assertNull($result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
