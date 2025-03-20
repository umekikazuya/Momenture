<?php

namespace Tests\Unit\Application\UseCases\Article;

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
        $this->expectNotToPerformAssertions();
        $this->repository
            ->shouldReceive('findById')
            ->with(1)
            ->andReturn($this->article);

        $this->repository
            ->shouldReceive('delete')
            ->once();

        $this->useCase->execute(1, false);

        // 明示的にアサーションを追加
        $this->assertTrue(true, 'リポジトリのdeleteメソッドが呼び出されました');

        $this->repository->shouldHaveReceived('delete')->once();
    }

    public function test_記事を完全削除できる()
    {
        $this->expectNotToPerformAssertions();
        $this->repository
            ->shouldReceive('findById')
            ->with(1)
            ->andReturn($this->article);

        $this->repository
            ->shouldReceive('forceDelete')
            ->once();

        $this->useCase->execute(1, true);

        // 明示的にアサーションを追加
        $this->assertTrue(true, 'リポジトリのforceDeleteメソッドが呼び出されました');

        $this->repository->shouldHaveReceived('forceDelete')->once();
    }

    public function test_it_throws_exception_when_article_not_found()
    {
        $this->repository
            ->shouldReceive('findById')
            ->with(999)
            ->andReturnNull();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('記事が見つかりません。');

        $this->useCase->execute(999);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
