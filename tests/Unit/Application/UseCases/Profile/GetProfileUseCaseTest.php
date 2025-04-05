<?php

declare(strict_types=1);

namespace Tests\Unit\Application\UseCases\Profile;

use App\Application\DTOs\ProfileDto;
use App\Application\Mappers\ProfileMapperInterface;
use App\Application\UseCases\Profile\GetProfileUseCase;
use App\Domain\Entities\Profile;
use App\Domain\Repositories\ProfileRepositoryInterface;
use DomainException;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class GetProfileUseCaseTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_execute_returns_profile_dto(): void
    {
        $profile = Mockery::mock(Profile::class);
        $dto = new ProfileDto(
            id: 1,
            address: 'Tokyo',
            displayName: 'name name',
            displayShortName: 'Kazu',
            from: 'Japan',
            github: 'name',
            introduction: 'Hello world',
            job: 'Developer',
            likes: ['PHP', 'Laravel'],
            qiita: 'qiita_id',
            skills: ['DDD', 'TDD'],
            summaryIntroduction: 'Profile summary',
            zenn: 'zenn_id'
        );

        $repository = Mockery::mock(ProfileRepositoryInterface::class);
        $repository->shouldReceive('find')->once()->andReturn($profile);

        $mapper = Mockery::mock(ProfileMapperInterface::class);
        $mapper->shouldReceive('toDto')->once()->with($profile)->andReturn($dto);

        $useCase = new GetProfileUseCase($repository, $mapper);

        $result = $useCase->execute();

        $this->assertInstanceOf(ProfileDto::class, $result);
        $this->assertSame('name name', $result->displayName);
        $this->assertSame(['PHP', 'Laravel'], $result->likes);
    }

    public function test_execute_throws_domain_exception_when_repository_fails(): void
    {
        $repository = Mockery::mock(ProfileRepositoryInterface::class);
        $repository->shouldReceive('find')->once()->andThrow(new DomainException('Repository error'));

        $mapper = Mockery::mock(ProfileMapperInterface::class);
        $mapper->shouldNotReceive('toDto');

        $useCase = new GetProfileUseCase($repository, $mapper);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('プロフィール情報の取得に失敗しました。');

        $useCase->execute();
    }

    public function test_execute_throws_runtime_exception_when_generic_error_occurs(): void
    {
        $originalException = new Exception('Database connection error', 123);

        $repository = Mockery::mock(ProfileRepositoryInterface::class);
        $repository->shouldReceive('find')->once()->andThrow($originalException);

        $mapper = Mockery::mock(ProfileMapperInterface::class);
        $mapper->shouldNotReceive('toDto');

        $useCase = new GetProfileUseCase($repository, $mapper);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Database connection error');
        $this->expectExceptionCode(123);

        $useCase->execute();
    }

    public function test_execute_throws_domain_exception_when_mapper_fails(): void
    {
        $profile = Mockery::mock(Profile::class);

        $repository = Mockery::mock(ProfileRepositoryInterface::class);
        $repository->shouldReceive('find')->once()->andReturn($profile);

        $mapper = Mockery::mock(ProfileMapperInterface::class);
        $mapper->shouldReceive('toDto')
            ->once()
            ->with($profile)
            ->andThrow(new DomainException('Mapping error'));

        $useCase = new GetProfileUseCase($repository, $mapper);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('プロフィール情報の取得に失敗しました。');

        $useCase->execute();
    }

    public function test_execute_throws_runtime_exception_when_mapper_throws_generic_error(): void
    {
        $profile = Mockery::mock(Profile::class);
        $mappingError = new Exception('Invalid profile data structure', 422);

        $repository = Mockery::mock(ProfileRepositoryInterface::class);
        $repository->shouldReceive('find')->once()->andReturn($profile);

        $mapper = Mockery::mock(ProfileMapperInterface::class);
        $mapper->shouldReceive('toDto')
            ->once()
            ->with($profile)
            ->andThrow($mappingError);

        $useCase = new GetProfileUseCase($repository, $mapper);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Invalid profile data structure');
        $this->expectExceptionCode(422);

        $useCase->execute();
    }

    public function test_execute_returns_correctly_mapped_profile_dto(): void
    {
        $profile = Mockery::mock(Profile::class);

        // より詳細なDTOの検証
        $expectedDto = new ProfileDto(
            id: 42,
            address: 'Osaka, Japan',
            displayName: 'テスト ユーザー',
            displayShortName: 'テストさん',
            from: 'Kyoto',
            github: 'test-github',
            introduction: '詳細な自己紹介文がここに入ります。',
            job: 'Software Engineer',
            likes: ['Music', 'Sports', 'Programming'],
            qiita: 'test-qiita',
            skills: ['PHP', 'Laravel', 'DDD', 'TDD', 'JavaScript'],
            summaryIntroduction: '簡潔な自己紹介',
            zenn: 'test-zenn'
        );

        $repository = Mockery::mock(ProfileRepositoryInterface::class);
        $repository->shouldReceive('find')->once()->andReturn($profile);

        $mapper = Mockery::mock(ProfileMapperInterface::class);
        $mapper->shouldReceive('toDto')->once()->with($profile)->andReturn($expectedDto);

        $useCase = new GetProfileUseCase($repository, $mapper);

        $result = $useCase->execute();

        // すべてのフィールドを徹底的に検証
        $this->assertInstanceOf(ProfileDto::class, $result);
        $this->assertSame(42, $result->id);
        $this->assertSame('Osaka, Japan', $result->address);
        $this->assertSame('テスト ユーザー', $result->displayName);
        $this->assertSame('テストさん', $result->displayShortName);
        $this->assertSame('Kyoto', $result->from);
        $this->assertSame('test-github', $result->github);
        $this->assertSame('詳細な自己紹介文がここに入ります。', $result->introduction);
        $this->assertSame('Software Engineer', $result->job);
        $this->assertSame(['Music', 'Sports', 'Programming'], $result->likes);
        $this->assertSame('test-qiita', $result->qiita);
        $this->assertSame(['PHP', 'Laravel', 'DDD', 'TDD', 'JavaScript'], $result->skills);
        $this->assertSame('簡潔な自己紹介', $result->summaryIntroduction);
        $this->assertSame('test-zenn', $result->zenn);
    }
}
