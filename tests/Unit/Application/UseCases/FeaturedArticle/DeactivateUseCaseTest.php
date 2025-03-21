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
        $repo->shouldReceive('findById')->andReturn(Mockery::mock(FeaturedArticle::class));
        $repo->shouldReceive('deactivate')->once();

        $useCase = new DeactivateUseCase($repo);
        $useCase->handle(new FeaturedArticleId(1));
    }
}
