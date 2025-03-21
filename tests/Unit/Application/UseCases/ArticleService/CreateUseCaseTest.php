<?php

namespace Tests\Unit\Application\UseCases\ArticleService;

use App\Application\UseCases\ArticleService\CreateUseCase;
use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleServiceRepositoryInterface;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;
use PHPUnit\Framework\TestCase;

class CreateUseCaseTest extends TestCase
{
    public function test_execute_creates_article_service_and_calls_repository(): void
    {
        // Arrange
        $mockRepository = $this->createMock(ArticleServiceRepositoryInterface::class);
        $mockRepository->expects($this->once())
            ->method('create')
            ->with($this->isInstanceOf(ArticleService::class));

        $useCase = new CreateUseCase($mockRepository);
        $name = 'Sample Article Service';

        // Act
        $result = $useCase->execute($name);

        // Assert
        $this->assertInstanceOf(ArticleService::class, $result);
        $this->assertEquals(new ArticleServiceName($name), $result->name());
        $this->assertInstanceOf(ArticleServiceId::class, $result->id());
    }
}
