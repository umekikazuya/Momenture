<?php

namespace Tests\Unit\Application\UseCases\FeaturedArticle;

use App\Application\UseCases\FeaturedArticle\AssignArticleUseCase;
use App\Domain\Repositories\FeaturedArticleRepositoryInterface;
use App\Domain\ValueObjects\FeaturedArticleId;
use App\Domain\ValueObjects\FeaturedPriority;
use Mockery;
use PHPUnit\Framework\TestCase;

class AssignArticleUseCaseTest extends TestCase
{
    public function test_正常に注目記事登録できる()
    {
        $repo = Mockery::mock(FeaturedArticleRepositoryInterface::class);
        $repo->shouldReceive('countActive')->andReturn(3);
        $repo->shouldReceive('add')->once();

        $useCase = new AssignArticleUseCase($repo, 5);
        $useCase->handle(articleId: new FeaturedArticleId(10), priority: new FeaturedPriority(1));
    }

    public function test_上限を超えた場合は例外を投げる()
    {
        $repo = Mockery::mock(FeaturedArticleRepositoryInterface::class);
        $repo->shouldReceive('countActive')->andReturn(5); // 上限
        $useCase = new AssignArticleUseCase($repo, 5);

        $this->expectException(\DomainException::class);
        $useCase->handle(articleId: new FeaturedArticleId(11), priority: new FeaturedPriority(1));
    }
}
