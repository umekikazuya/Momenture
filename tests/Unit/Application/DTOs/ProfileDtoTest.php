<?php

declare(strict_types=1);

namespace Tests\Unit\Application\DTOs;

use App\Application\DTOs\ProfileDto;
use PHPUnit\Framework\TestCase;

class ProfileDtoTest extends TestCase
{
    public function test_from_array_creates_dto_with_expected_values(): void
    {
        $data = [
            'id' => 42,
            'address' => 'Tokyo',
            'display_name' => 'name name',
            'display_short_name' => 'name',
            'from' => 'Osaka',
            'github' => 'kazuya-github',
            'introduction' => 'Hello world',
            'job' => 'Engineer',
            'likes' => ['DDD', 'PHP'],
            'qiita' => 'qiita-user',
            'skills' => ['Laravel', 'Vue'],
            'summary_introduction' => 'Dev from JP',
            'zenn' => 'zenn-user',
        ];

        $dto = ProfileDto::fromArray($data);

        $this->assertSame(42, $dto->id);
        $this->assertSame('Tokyo', $dto->address);
        $this->assertSame('name name', $dto->displayName);
        $this->assertSame('name', $dto->displayShortName);
        $this->assertSame('Osaka', $dto->from);
        $this->assertSame('kazuya-github', $dto->github);
        $this->assertSame('Hello world', $dto->introduction);
        $this->assertSame('Engineer', $dto->job);
        $this->assertSame(['DDD', 'PHP'], $dto->likes);
        $this->assertSame('qiita-user', $dto->qiita);
        $this->assertSame(['Laravel', 'Vue'], $dto->skills);
        $this->assertSame('Dev from JP', $dto->summaryIntroduction);
        $this->assertSame('zenn-user', $dto->zenn);
    }

    public function test_to_array_outputs_expected_format(): void
    {
        $dto = new ProfileDto(
            id: 1,
            address: 'Tokyo',
            displayName: 'name',
            displayShortName: 'name',
            from: 'Kyoto',
            github: 'github-user',
            introduction: 'Intro text',
            job: 'Developer',
            likes: ['Clean Code'],
            qiita: 'qiita-id',
            skills: ['PHP'],
            summaryIntroduction: 'Summary here',
            zenn: 'zenn-id'
        );

        $expected = [
            'id' => 1,
            'address' => 'Tokyo',
            'display_name' => 'name',
            'display_short_name' => 'name',
            'from' => 'Kyoto',
            'github' => 'github-user',
            'introduction' => 'Intro text',
            'job' => 'Developer',
            'likes' => ['Clean Code'],
            'qiita' => 'qiita-id',
            'skills' => ['PHP'],
            'summary_introduction' => 'Summary here',
            'zenn' => 'zenn-id',
        ];

        $this->assertSame($expected, $dto->toArray());
    }

    public function test_from_array_with_missing_fields_uses_defaults(): void
    {
        // 一部のフィールドが欠けているケース
        $data = [
            'id' => 99,
            'display_name' => 'Test User',
        ];

        $dto = ProfileDto::fromArray($data);

        $this->assertSame(99, $dto->id);
        $this->assertSame('Test User', $dto->displayName);
        $this->assertSame('', $dto->address);
        $this->assertSame('', $dto->displayShortName);
        $this->assertSame('', $dto->from);
        $this->assertSame('', $dto->github);
        $this->assertSame('', $dto->introduction);
        $this->assertSame('', $dto->job);
        $this->assertSame([], $dto->likes);
        $this->assertSame('', $dto->qiita);
        $this->assertSame([], $dto->skills);
        $this->assertSame('', $dto->summaryIntroduction);
        $this->assertSame('', $dto->zenn);
    }

    public function test_from_array_with_empty_array_uses_defaults(): void
    {
        // 空の配列からDTOを作成
        $dto = ProfileDto::fromArray([]);

        $this->assertSame(1, $dto->id); // デフォルトID値
        $this->assertSame('', $dto->address);
        $this->assertSame('', $dto->displayName);
        $this->assertSame('', $dto->displayShortName);
        $this->assertSame('', $dto->from);
        $this->assertSame('', $dto->github);
        $this->assertSame('', $dto->introduction);
        $this->assertSame('', $dto->job);
        $this->assertSame([], $dto->likes);
        $this->assertSame('', $dto->qiita);
        $this->assertSame([], $dto->skills);
        $this->assertSame('', $dto->summaryIntroduction);
        $this->assertSame('', $dto->zenn);
    }

    public function test_to_array_with_null_values_returns_empty_strings(): void
    {
        // nullを含むDTOが配列に正しく変換されるか
        $dto = new ProfileDto(
            id: 5,
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

        $array = $dto->toArray();

        $this->assertSame(5, $array['id']);
        $this->assertSame('', $array['address']);
        $this->assertSame('', $array['display_name']);
        $this->assertSame('', $array['display_short_name']);
        $this->assertSame('', $array['from']);
        $this->assertSame('', $array['github']);
        $this->assertSame('', $array['introduction']);
        $this->assertSame('', $array['job']);
        $this->assertSame([], $array['likes']);
        $this->assertSame('', $array['qiita']);
        $this->assertSame([], $array['skills']);
        $this->assertSame('', $array['summary_introduction']);
        $this->assertSame('', $array['zenn']);
    }

    public function test_id_type_conversion(): void
    {
        // 文字列IDが整数に変換されることを確認
        $data = [
            'id' => '123',
            'display_name' => 'Test',
        ];

        $dto = ProfileDto::fromArray($data);
        $this->assertSame(123, $dto->id);
        $this->assertIsInt($dto->id);
    }

    public function test_round_trip_conversion(): void
    {
        // DTOから配列、配列からDTOへの往復変換が一致することを確認
        $originalDto = new ProfileDto(
            id: 42,
            address: 'Test Address',
            displayName: 'Test Name',
            displayShortName: 'Test',
            from: 'Test City',
            github: 'test-github',
            introduction: 'Test introduction',
            job: 'Test job',
            likes: ['Test1', 'Test2'],
            qiita: 'test-qiita',
            skills: ['Skill1', 'Skill2'],
            summaryIntroduction: 'Test summary',
            zenn: 'test-zenn'
        );

        $array = $originalDto->toArray();
        $newDto = ProfileDto::fromArray($array);

        $this->assertSame($originalDto->id, $newDto->id);
        $this->assertSame($originalDto->address, $newDto->address);
        $this->assertSame($originalDto->displayName, $newDto->displayName);
        $this->assertSame($originalDto->displayShortName, $newDto->displayShortName);
        $this->assertSame($originalDto->from, $newDto->from);
        $this->assertSame($originalDto->github, $newDto->github);
        $this->assertSame($originalDto->introduction, $newDto->introduction);
        $this->assertSame($originalDto->job, $newDto->job);
        $this->assertSame($originalDto->likes, $newDto->likes);
        $this->assertSame($originalDto->qiita, $newDto->qiita);
        $this->assertSame($originalDto->skills, $newDto->skills);
        $this->assertSame($originalDto->summaryIntroduction, $newDto->summaryIntroduction);
        $this->assertSame($originalDto->zenn, $newDto->zenn);
    }
}
