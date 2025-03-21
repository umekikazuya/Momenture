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
        $repo->shouldReceive('findById')->andReturn(Mockery::mock(FeaturedArticle::class));
        $repo->shouldReceive('updatePriority')->once();

        $useCase = new ChangePriorityUseCase($repo);
        $useCase->handle(new FeaturedArticleId(1), new FeaturedPriority(2));
    }
}
