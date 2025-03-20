<?php

use App\Application\UseCases\ArticleService\UpdateUseCase;
use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleServiceRepositoryInterface;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;
use PHPUnit\Framework\TestCase;

class UpdateUseCaseTest extends TestCase
{
    public function test_execute_updates_article_service_and_calls_repository(): void
    {
        // Arrange
        $mockRepository = $this->createMock(ArticleServiceRepositoryInterface::class);
        $mockRepository->expects($this->once())
            ->method('update')
            ->with($this->isInstanceOf(ArticleService::class));

        $useCase = new UpdateUseCase($mockRepository);
        $id = new ArticleServiceId(1);
        $name = new ArticleServiceName('Updated Article Service');

        // Act
        $result = $useCase->execute(new ArticleService($id, $name));

        // Assert
        $this->assertInstanceOf(ArticleService::class, $result);
        $this->assertEquals($name, $result->name());
        $this->assertInstanceOf(ArticleServiceId::class, $result->id());
    }
}
