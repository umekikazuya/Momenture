<?php

declare(strict_types=1);

namespace Tests\Unit\Application\UseCases\Profile;

use App\Application\DTOs\ProfileDto;
use App\Application\Mappers\ProfileMapperInterface;
use App\Application\UseCases\Profile\UpdateProfileUseCase;
use App\Domain\Entities\Profile;
use App\Domain\Repositories\ProfileRepositoryInterface;
use DomainException;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class UpdateProfileUseCaseTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_execute_updates_profile_successfully(): void
    {
        // Arrange
        $dto = new ProfileDto(
            id: 1,
            address: 'Tokyo',
            displayName: 'Test User',
            displayShortName: 'Test',
            from: 'Japan',
            github: 'testuser',
            introduction: 'Hello world',
            job: 'Developer',
            likes: ['PHP', 'Laravel'],
            qiita: 'testuser',
            skills: ['DDD', 'TDD'],
            summaryIntroduction: 'Profile summary',
            zenn: 'testuser'
        );

        $profile = Mockery::mock(Profile::class);

        $mapper = Mockery::mock(ProfileMapperInterface::class);
        $mapper->shouldReceive('toEntity')
            ->once()
            ->with($dto)
            ->andReturn($profile);

        $repository = Mockery::mock(ProfileRepositoryInterface::class);
        $repository->shouldReceive('update')
            ->once()
            ->with($profile)
            ->andReturn($profile);

        $useCase = new UpdateProfileUseCase($repository, $mapper);

        // Act & Assert - 例外が発生しないことを検証
        $result = $useCase->execute($dto);
        $this->assertSame(true, $result); // アサーションが必要なので、例外が投げられなければテスト成功とする
    }

    public function test_execute_throws_domain_exception_when_mapper_fails(): void
    {
        // Arrange
        $dto = new ProfileDto(
            id: 1,
            address: 'Tokyo',
            displayName: 'Test User',
            displayShortName: 'Test',
            from: 'Japan',
            github: 'testuser',
            introduction: 'Hello world',
            job: 'Developer',
            likes: ['PHP', 'Laravel'],
            qiita: 'testuser',
            skills: ['DDD', 'TDD'],
            summaryIntroduction: 'Profile summary',
            zenn: 'testuser'
        );

        $mapper = Mockery::mock(ProfileMapperInterface::class);
        $mapper->shouldReceive('toEntity')
            ->once()
            ->with($dto)
            ->andThrow(new DomainException('Mapping error'));

        $repository = Mockery::mock(ProfileRepositoryInterface::class);
        $repository->shouldNotReceive('update');

        $useCase = new UpdateProfileUseCase($repository, $mapper);

        // Act & Assert
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('プロフィール情報の更新に失敗しました。');
        $this->expectExceptionCode(500);

        $useCase->execute($dto);
    }

    public function test_execute_throws_domain_exception_when_repository_fails(): void
    {
        // Arrange
        $dto = new ProfileDto(
            id: 1,
            address: 'Tokyo',
            displayName: 'Test User',
            displayShortName: 'Test',
            from: 'Japan',
            github: 'testuser',
            introduction: 'Hello world',
            job: 'Developer',
            likes: ['PHP', 'Laravel'],
            qiita: 'testuser',
            skills: ['DDD', 'TDD'],
            summaryIntroduction: 'Profile summary',
            zenn: 'testuser'
        );

        $profile = Mockery::mock(Profile::class);

        $mapper = Mockery::mock(ProfileMapperInterface::class);
        $mapper->shouldReceive('toEntity')
            ->once()
            ->with($dto)
            ->andReturn($profile);

        $repository = Mockery::mock(ProfileRepositoryInterface::class);
        $repository->shouldReceive('update')
            ->once()
            ->with($profile)
            ->andThrow(new DomainException('Repository error'));

        $useCase = new UpdateProfileUseCase($repository, $mapper);

        // Act & Assert
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('プロフィール情報の更新に失敗しました。');
        $this->expectExceptionCode(500);

        $useCase->execute($dto);
    }

    public function test_execute_throws_runtime_exception_when_generic_error_occurs(): void
    {
        // Arrange
        $dto = new ProfileDto(
            id: 1,
            address: 'Tokyo',
            displayName: 'Test User',
            displayShortName: 'Test',
            from: 'Japan',
            github: 'testuser',
            introduction: 'Hello world',
            job: 'Developer',
            likes: ['PHP', 'Laravel'],
            qiita: 'testuser',
            skills: ['DDD', 'TDD'],
            summaryIntroduction: 'Profile summary',
            zenn: 'testuser'
        );

        $profile = Mockery::mock(Profile::class);
        $originalException = new Exception('Database connection error', 123);

        $mapper = Mockery::mock(ProfileMapperInterface::class);
        $mapper->shouldReceive('toEntity')
            ->once()
            ->with($dto)
            ->andReturn($profile);

        $repository = Mockery::mock(ProfileRepositoryInterface::class);
        $repository->shouldReceive('update')
            ->once()
            ->with($profile)
            ->andThrow($originalException);

        $useCase = new UpdateProfileUseCase($repository, $mapper);

        // Act & Assert
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Database connection error');
        $this->expectExceptionCode(123);

        $useCase->execute($dto);
    }
}
