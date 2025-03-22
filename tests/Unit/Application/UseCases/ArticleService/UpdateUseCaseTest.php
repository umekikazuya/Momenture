<?php

namespace Tests\Unit\Application\UseCases\ArticleService;

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
        $id = new ArticleServiceId(1);
        $name = new ArticleServiceName('Updated Article Service');

        // ArticleServiceエンティティのモック
        $mockArticleService = $this->createMock(ArticleService::class);
        $mockArticleService->expects($this->once())
            ->method('updateName')
            ->with($this->equalTo($name));
        $mockArticleService->method('name')->willReturn($name);
        $mockArticleService->method('id')->willReturn($id);

        // Repositoryのモック
        $mockRepository = $this->createMock(ArticleServiceRepositoryInterface::class);
        $mockRepository->method('findById')->with($id->value())->willReturn($mockArticleService);
        $mockRepository->expects($this->once())
            ->method('update')
            ->with($mockArticleService);

        $useCase = new UpdateUseCase($mockRepository);

        // Act
        $result = $useCase->execute($id, $name);

        // Assert
        $this->assertInstanceOf(ArticleService::class, $result);
    }

    public function test_execute_calls_update_name_method(): void
    {
        // Arrange
        $id = new ArticleServiceId(1);
        $name = new ArticleServiceName('Updated Article Service');

        $mockArticleService = $this->createMock(ArticleService::class);
        $mockArticleService->expects($this->once())
            ->method('updateName')
            ->with($this->equalTo($name));
        $mockArticleService->method('name')->willReturn($name);
        $mockArticleService->method('id')->willReturn($id);

        $mockRepository = $this->createMock(ArticleServiceRepositoryInterface::class);
        $mockRepository->method('findById')->with($id->value())->willReturn($mockArticleService);
        $mockRepository->expects($this->once())
            ->method('update')
            ->with($mockArticleService);

        $useCase = new UpdateUseCase($mockRepository);

        // Act
        $useCase->execute($id, $name);
    }

    public function test_execute_throws_exception_when_article_service_not_found(): void
    {
        // Arrange
        $id = new ArticleServiceId(999);
        $name = new ArticleServiceName('Updated Article Service');

        $mockRepository = $this->createMock(ArticleServiceRepositoryInterface::class);
        $mockRepository
            ->method('findById')
            ->with($id->value())
            ->willThrowException(new \DomainException('更新対象の記事サービスが見つかりませんでした。'));

        $useCase = new UpdateUseCase($mockRepository);

        // Assert
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('更新対象の記事サービスが見つかりませんでした。');

        // Act
        $useCase->execute($id, $name);
    }
}
