<?php

namespace Tests\Unit\Application\UseCases\FeaturedArticle;

use App\Application\UseCases\FeaturedArticle\ChangePriorityUseCase;
use App\Domain\Entities\FeaturedArticle;
use App\Domain\Repositories\FeaturedArticleRepositoryInterface;
use App\Domain\ValueObjects\FeaturedArticleId;
use App\Domain\ValueObjects\FeaturedPriority;
use Mockery;
use PHPUnit\Framework\TestCase;

class ChangePriorityUseCaseTest extends TestCase
{
    public function test_優先度を正しく更新する()
    {
        $repo = Mockery::mock(FeaturedArticleRepositoryInterface::class);
        $articleMock = Mockery::mock(FeaturedArticle::class);
        $articleMock->shouldReceive('isActive')->andReturn(true);
        $repo->shouldReceive('findById')->andReturn($articleMock);
        $repo->shouldReceive('updatePriority')->once();

        $useCase = new ChangePriorityUseCase($repo);
        $useCase->handle(new FeaturedArticleId(1), new FeaturedPriority(2));
    }

    public function test_存在しない記事の場合に例外が発生する()
    {
        $repo = Mockery::mock(FeaturedArticleRepositoryInterface::class);
        $repo->shouldReceive('findById')->andReturn(null);
        $repo->shouldNotReceive('updatePriority');

        $useCase = new ChangePriorityUseCase($repo);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('注目記事が見つかりません。');

        $useCase->handle(new FeaturedArticleId(999), new FeaturedPriority(2));
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
