<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Mappers;

use App\Application\DTOs\ProfileDto;
use App\Application\Mappers\ProfileMapper;
use App\Domain\Entities\Profile;
use App\Domain\ValueObjects\Profile\Like;
use App\Domain\ValueObjects\Profile\Likes;
use App\Domain\ValueObjects\Profile\ProfileAddress;
use App\Domain\ValueObjects\Profile\ProfileDisplayName;
use App\Domain\ValueObjects\Profile\ProfileFrom;
use App\Domain\ValueObjects\Profile\ProfileGithub;
use App\Domain\ValueObjects\Profile\ProfileId;
use App\Domain\ValueObjects\Profile\ProfileIntroduction;
use App\Domain\ValueObjects\Profile\ProfileJob;
use App\Domain\ValueObjects\Profile\ProfileQiita;
use App\Domain\ValueObjects\Profile\ProfileShortName;
use App\Domain\ValueObjects\Profile\ProfileSummaryIntroduction;
use App\Domain\ValueObjects\Profile\ProfileZenn;
use App\Domain\ValueObjects\Profile\Skill;
use App\Domain\ValueObjects\Profile\Skills;
use PHPUnit\Framework\TestCase;

class ProfileMapperTest extends TestCase
{
    private ProfileMapper $mapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mapper = new ProfileMapper();
    }

    public function test_to_entity_maps_dto_to_entity_correctly(): void
    {
        // テスト用のDTOを作成
        $dto = new ProfileDto(
            id: 42,
            address: 'Tokyo, Japan',
            displayName: 'Test User',
            displayShortName: 'Test',
            from: 'Osaka',
            github: 'test-github',
            introduction: 'Test introduction',
            job: 'Software Engineer',
            likes: ['Programming', 'Reading'],
            qiita: 'test-qiita',
            skills: ['PHP', 'Laravel', 'Vue.js'],
            summaryIntroduction: 'Short intro',
            zenn: 'test-zenn'
        );

        // DTOをエンティティに変換
        $entity = $this->mapper->toEntity($dto);

        // 変換結果を検証
        $this->assertInstanceOf(Profile::class, $entity);
        $this->assertSame(42, $entity->id()->value());
        $this->assertSame('Tokyo, Japan', $entity->address()->value());
        $this->assertSame('Test User', $entity->displayName()->value());
        $this->assertSame('Test', $entity->displayShortName()->value());
        $this->assertSame('Osaka', $entity->from()->value());
        $this->assertSame('test-github', $entity->github()->value());
        $this->assertSame('Test introduction', $entity->introduction()->value());
        $this->assertSame('Software Engineer', $entity->job()->value());
        $this->assertSame(['Programming', 'Reading'], $entity->likes()->toArray());
        $this->assertSame('test-qiita', $entity->qiita()->value());
        $this->assertSame(['PHP', 'Laravel', 'Vue.js'], array_map(fn ($skill) => $skill->value(), $entity->skills()->all()));
        $this->assertSame('Short intro', $entity->summaryIntroduction()->value());
        $this->assertSame('test-zenn', $entity->zenn()->value());
    }

    public function test_to_dto_maps_entity_to_dto_correctly(): void
    {
        // テスト用のエンティティを作成
        $entity = new Profile(
            new ProfileId(99),
            new ProfileAddress('Kyoto, Japan'),
            new ProfileDisplayName('Entity User'),
            new ProfileShortName('Entity'),
            new ProfileFrom('Tokyo'),
            new ProfileGithub('entity-github'),
            new ProfileIntroduction('Entity introduction'),
            new ProfileJob('Developer'),
            new Likes([new Like('TDD'), new Like('DDD')]),
            new ProfileQiita('entity-qiita'),
            new Skills([new Skill('JavaScript'), new Skill('TypeScript')]),
            new ProfileSummaryIntroduction('Entity summary'),
            new ProfileZenn('entity-zenn')
        );

        // エンティティをDTOに変換
        $dto = $this->mapper->toDto($entity);

        // 変換結果を検証
        $this->assertInstanceOf(ProfileDto::class, $dto);
        $this->assertSame(99, $dto->id);
        $this->assertSame('Kyoto, Japan', $dto->address);
        $this->assertSame('Entity User', $dto->displayName);
        $this->assertSame('Entity', $dto->displayShortName);
        $this->assertSame('Tokyo', $dto->from);
        $this->assertSame('entity-github', $dto->github);
        $this->assertSame('Entity introduction', $dto->introduction);
        $this->assertSame('Developer', $dto->job);
        $this->assertSame(['TDD', 'DDD'], $dto->likes);
        $this->assertSame('entity-qiita', $dto->qiita);
        $this->assertSame(['JavaScript', 'TypeScript'], $dto->skills);
        $this->assertSame('Entity summary', $dto->summaryIntroduction);
        $this->assertSame('entity-zenn', $dto->zenn);
    }

    public function test_roundtrip_conversion_consistency(): void
    {
        // テスト用のDTOを作成
        $originalDto = new ProfileDto(
            id: 123,
            address: 'Sapporo',
            displayName: 'Round Trip',
            displayShortName: 'RT',
            from: 'Hokkaido',
            github: 'roundtrip-github',
            introduction: 'Testing roundtrip conversion',
            job: 'QA Engineer',
            likes: ['Testing', 'Quality'],
            qiita: 'roundtrip-qiita',
            skills: ['PHPUnit', 'Jest'],
            summaryIntroduction: 'RT summary',
            zenn: 'roundtrip-zenn'
        );

        // DTO → エンティティ → DTO の往復変換
        $entity = $this->mapper->toEntity($originalDto);
        $resultDto = $this->mapper->toDto($entity);

        // 変換前後でデータが一致することを確認
        $this->assertSame($originalDto->id, $resultDto->id);
        $this->assertSame($originalDto->address, $resultDto->address);
        $this->assertSame($originalDto->displayName, $resultDto->displayName);
        $this->assertSame($originalDto->displayShortName, $resultDto->displayShortName);
        $this->assertSame($originalDto->from, $resultDto->from);
        $this->assertSame($originalDto->github, $resultDto->github);
        $this->assertSame($originalDto->introduction, $resultDto->introduction);
        $this->assertSame($originalDto->job, $resultDto->job);
        $this->assertSame($originalDto->likes, $resultDto->likes);
        $this->assertSame($originalDto->qiita, $resultDto->qiita);
        $this->assertSame($originalDto->skills, $resultDto->skills);
        $this->assertSame($originalDto->summaryIntroduction, $resultDto->summaryIntroduction);
        $this->assertSame($originalDto->zenn, $resultDto->zenn);
    }

    public function test_to_entity_with_null_values(): void
    {
        // null値を含むDTOをエンティティに変換
        $dto = new ProfileDto(
            id: 10,
            address: null,
            displayName: null,
            displayShortName: null,
            from: null,
            github: null,
            introduction: null,
            job: null,
            likes: [],
            qiita: null,
            skills: [],
            summaryIntroduction: null,
            zenn: null
        );

        $entity = $this->mapper->toEntity($dto);

        // 変換結果を検証（null値は空文字に変換されていること）
        $this->assertSame(10, $entity->id()->value());
        $this->assertSame('', $entity->address()->value());
        $this->assertSame('', $entity->displayName()->value());
        $this->assertSame('', $entity->displayShortName()->value());
        $this->assertSame('', $entity->from()->value());
        $this->assertSame('', $entity->github()->value());
        $this->assertSame('', $entity->introduction()->value());
        $this->assertSame('', $entity->job()->value());
        $this->assertSame([], $entity->likes()->toArray());
        $this->assertSame('', $entity->qiita()->value());
        $this->assertSame([], array_map(fn ($skill) => $skill->value(), $entity->skills()->all()));
        $this->assertSame('', $entity->summaryIntroduction()->value());
        $this->assertSame('', $entity->zenn()->value());
    }
}
