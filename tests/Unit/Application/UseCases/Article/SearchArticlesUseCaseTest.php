<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\UseCases\Article\SearchArticlesUseCase;
use App\Domain\Repositories\ArticleRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Mockery;

class SearchArticlesUseCaseTest extends TestCase
{
    private $repository;
    private $useCase;

    protected function setUp(): void
    {
        $this->repository = Mockery::mock(ArticleRepositoryInterface::class);
        $this->useCase = new SearchArticlesUseCase($this->repository);
    }

    public function test_記事を検索できる()
    {
        $keyword = "Laravel";
        $serviceId = 1;
        $tagId = 2;

        $this->repository
            ->shouldReceive('search')
            ->with($keyword, $serviceId, $tagId)
            ->andReturn(['dummy_data']);

        $result = $this->useCase->execute($keyword, $serviceId, $tagId);

        $this->assertEquals(['dummy_data'], $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
