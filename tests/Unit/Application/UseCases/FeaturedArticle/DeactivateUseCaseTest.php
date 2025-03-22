<?php

namespace Tests\Unit\Application\UseCases\FeaturedArticle;

use App\Application\UseCases\FeaturedArticle\DeactivateUseCase;
use App\Domain\Entities\FeaturedArticle;
use App\Domain\Repositories\FeaturedArticleRepositoryInterface;
use App\Domain\ValueObjects\FeaturedArticleId;
use Mockery;
use PHPUnit\Framework\TestCase;

class DeactivateUseCaseTest extends TestCase
{
    public function test_正常に無効化される()
    {
        $repo = Mockery::mock(FeaturedArticleRepositoryInterface::class);
        $articleMock = Mockery::mock(FeaturedArticle::class);
        $articleMock->shouldReceive('isActive')->andReturn(true);
        $repo->shouldReceive('findById')->andReturn($articleMock);
        $repo->shouldReceive('deactivate')->once();

        $useCase = new DeactivateUseCase($repo);
        $useCase->handle(new FeaturedArticleId(1));
    }

    public function test_存在しない記事の場合に例外が発生する()
    {
        $repo = Mockery::mock(FeaturedArticleRepositoryInterface::class);
        $repo->shouldReceive('findById')->andReturn(null);
        $repo->shouldNotReceive('deactivate');

        $useCase = new DeactivateUseCase($repo);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('注目記事が見つかりません。');

        $useCase->handle(new FeaturedArticleId(999));
    }

    public function test_既に無効な場合は例外が発生する()
    {
        $articleMock = Mockery::mock(FeaturedArticle::class);
        $articleMock->shouldReceive('isActive')->andReturn(false);

        $repo = Mockery::mock(FeaturedArticleRepositoryInterface::class);
        $repo->shouldReceive('findById')->andReturn($articleMock);
        $repo->shouldNotReceive('deactivate');

        $useCase = new DeactivateUseCase($repo);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('注目記事は既に無効です。');

        $useCase->handle(new FeaturedArticleId(1));
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
