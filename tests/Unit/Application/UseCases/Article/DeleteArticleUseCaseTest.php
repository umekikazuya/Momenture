<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\UseCases\Article\DeleteArticleUseCase;
use App\Domain\Entities\Article;
use App\Domain\Repositories\ArticleRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class DeleteArticleUseCaseTest extends TestCase
{
    private $repository;

    private $useCase;

    private $article;

    protected function setUp(): void
    {
        $this->repository = Mockery::mock(ArticleRepositoryInterface::class);
        $this->useCase = new DeleteArticleUseCase($this->repository);

        $this->article = Mockery::mock(Article::class);
    }

    public function test_記事を削除できる()
    {
        $this->repository
            ->shouldReceive('findById')
            ->with(1)
            ->andReturn($this->article);

        $this->repository
            ->shouldReceive('delete')
            ->once();

        $this->useCase->execute(1, false);
    }

    public function test_記事を完全削除できる()
    {
        $this->repository
            ->shouldReceive('findById')
            ->with(1)
            ->andReturn($this->article);

        $this->repository
            ->shouldReceive('forceDelete')
            ->once();

        $this->useCase->execute(1, true);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
