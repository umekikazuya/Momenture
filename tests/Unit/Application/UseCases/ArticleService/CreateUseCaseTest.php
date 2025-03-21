<?php

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

    public function test_execute_throws_exception_when_name_is_empty(): void
    {
        // Arrange
        $mockRepository = $this->createMock(ArticleServiceRepositoryInterface::class);
        $mockRepository->expects($this->never())
            ->method('create');

        $useCase = new CreateUseCase($mockRepository);
        $emptyName = '';

        // Assert & Act
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('サービス名は空白にできません。');

        $useCase->execute($emptyName);
    }

    public function test_execute_throws_exception_when_name_is_whitespace_only(): void
    {
        // Arrange
        $mockRepository = $this->createMock(ArticleServiceRepositoryInterface::class);
        $mockRepository->expects($this->never())
            ->method('create');

        $useCase = new CreateUseCase($mockRepository);
        $whitespaceOnlyName = '   ';

        // Assert & Act
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('サービス名は空白にできません。');

        $useCase->execute($whitespaceOnlyName);
    }

    public function test_execute_throws_exception_when_name_exceeds_maximum_length(): void
    {
        // Arrange
        $mockRepository = $this->createMock(ArticleServiceRepositoryInterface::class);
        $mockRepository->expects($this->never())
            ->method('create');

        $useCase = new CreateUseCase($mockRepository);
        $tooLongName = str_repeat('a', 101); // 101 characters exceeds the 100 character limit

        // Assert & Act
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('サービス名は100文字以内にしてください。');

        $useCase->execute($tooLongName);
    }
}
