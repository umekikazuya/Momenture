<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\UseCases\Article\ChangeArticleStatusUseCase;
use App\Application\UseCases\Article\ChangeArticleStatusUseCaseInterface;
use App\Domain\Entities\Article;
use App\Domain\Enums\ArticleStatus;
use App\Domain\Repositories\ArticleRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class ChangeArticleStatusUseCaseTest extends TestCase
{
    private $repository;

    private ChangeArticleStatusUseCaseInterface $useCase;

    private $article;

    protected function setUp(): void
    {
        $this->repository = Mockery::mock(ArticleRepositoryInterface::class);
        $this->useCase = new ChangeArticleStatusUseCase($this->repository);

        $this->article = Mockery::mock(Article::class);
    }

    public function test_記事の公開状態を変更できる()
    {
        $this->repository
            ->shouldReceive('findById')
            ->with(1)
            ->andReturn($this->article);

        $this->article
            ->shouldReceive('changeStatus')
            ->with(ArticleStatus::PUBLISHED);

        $this->repository
            ->shouldReceive('save')
            ->once();

        $this->useCase->execute(1, ArticleStatus::PUBLISHED->value);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
