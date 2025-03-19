<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\UseCases\Article\FindArticlesUseCase;
use App\Domain\Repositories\ArticleRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Mockery;

class FindArticlesUseCaseTest extends TestCase
{
    private $repository;
    private $useCase;

    protected function setUp(): void
    {
        $this->repository = Mockery::mock(ArticleRepositoryInterface::class);
        $this->useCase = new FindArticlesUseCase($this->repository);
    }

    public function test_記事一覧を取得できる()
    {
        $filters = ['status' => 'published'];
        $sort = 'created_at_desc';
        $page = 1;
        $perPage = 10;

        $this->repository
            ->shouldReceive('findAll')
            ->with($filters, $sort, $page, $perPage)
            ->andReturn(['dummy_data']);

        $result = $this->useCase->execute($filters, $sort, $page, $perPage);

        $this->assertEquals(['dummy_data'], $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
