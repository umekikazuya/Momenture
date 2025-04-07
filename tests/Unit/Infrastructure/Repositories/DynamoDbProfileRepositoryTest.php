<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Repositories;

use App\Application\DTOs\ProfileDto;
use App\Application\Mappers\ProfileMapperInterface;
use App\Domain\Entities\Profile;
use App\Infrastructure\Repositories\DynamoDbProfileRepository;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\Result;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

// @todo DynamoDBのモックを作成してテストを実行する
class DynamoDbProfileRepositoryTest extends TestCase
{
    // private DynamoDbClient|MockObject $client;
    // private ProfileMapperInterface|MockObject $mapper;
    // private DynamoDbProfileRepository $repository;

    // protected function setUp(): void
    // {
    //     parent::setUp();

    //     $this->client = $this->createMock(DynamoDbClient::class);
    //     $this->mapper = $this->createMock(ProfileMapperInterface::class);
    //     $this->repository = new DynamoDbProfileRepository($this->client, $this->mapper);
    // }

    // public function testFindReturnsProfileWhenItemExists(): void
    // {
    //     // モックの設定
    //     $mockResult = new Result([
    //         'Item' => [
    //             'PK' => ['S' => 'PROFILE#ME'],
    //             'SK' => ['S' => 'LATEST'],
    //             'id' => ['N' => '1'],
    //             'display_name' => ['S' => 'テストユーザー'],
    //             'display_short_name' => ['S' => 'テスト'],
    //             'introduction' => ['S' => '自己紹介文です'],
    //             'summary_introduction' => ['S' => '要約文です'],
    //             'job' => ['S' => 'エンジニア'],
    //             'from' => ['S' => '東京'],
    //             'address' => ['S' => '東京都'],
    //             'github' => ['S' => 'https://github.com/test'],
    //             'qiita' => ['S' => 'https://qiita.com/test'],
    //             'zenn' => ['S' => 'https://zenn.dev/test'],
    //             'skills' => ['SS' => ['PHP', 'Laravel', 'AWS']],
    //             'likes' => ['SS' => ['映画鑑賞', '読書']],
    //         ],
    //     ]);

    //     $this->client
    //         ->expects($this->once())
    //         ->method('getItem')
    //         ->with([
    //             'TableName' => 'profiles',
    //             'Key' => [
    //                 'PK' => ['S' => 'PROFILE#ME'],
    //                 'SK' => ['S' => 'LATEST'],
    //             ],
    //         ])
    //         ->willReturn($mockResult);

    //     $expectedDto = ProfileDto::fromArray([
    //         'id' => '1',
    //         'display_name' => 'テストユーザー',
    //         'display_short_name' => 'テスト',
    //         'introduction' => '自己紹介文です',
    //         'summary_introduction' => '要約文です',
    //         'job' => 'エンジニア',
    //         'from' => '東京',
    //         'address' => '東京都',
    //         'github' => 'https://github.com/test',
    //         'qiita' => 'https://qiita.com/test',
    //         'zenn' => 'https://zenn.dev/test',
    //         'skills' => ['PHP', 'Laravel', 'AWS'],
    //         'likes' => ['映画鑑賞', '読書'],
    //     ]);

    //     $mockProfile = $this->createMock(Profile::class);

    //     $this->mapper
    //         ->expects($this->once())
    //         ->method('toEntity')
    //         ->with($this->callback(function ($dto) use ($expectedDto) {
    //             return $dto->id === $expectedDto->id
    //                 && $dto->displayName === $expectedDto->displayName
    //                 && $dto->skills === $expectedDto->skills;
    //         }))
    //         ->willReturn($mockProfile);

    //     // 実行
    //     $result = $this->repository->find();

    //     // 検証
    //     $this->assertSame($mockProfile, $result);
    // }

    // public function testFindThrowsDomainExceptionWhenItemNotFound(): void
    // {
    //     // モックの設定
    //     $mockResult = new Result([]);

    //     $this->client
    //         ->expects($this->once())
    //         ->method('getItem')
    //         ->willReturn($mockResult);

    //     // 例外の期待
    //     $this->expectException(\DomainException::class);
    //     $this->expectExceptionMessage('プロフィールが見つかりません。');

    //     // 実行
    //     $this->repository->find();
    // }

    // public function testFindThrowsRuntimeExceptionWhenDynamoDbExceptionOccurs(): void
    // {
    //     // モックの設定
    //     $this->client
    //         ->expects($this->once())
    //         ->method('getItem')
    //         ->willThrowException(new DynamoDbException(
    //             'DB接続エラー',
    //             $this->createMock(\Aws\CommandInterface::class)
    //         ));

    //     // 例外の期待
    //     $this->expectException(\RuntimeException::class);
    //     $this->expectExceptionMessage('DynamoDBからの取得に失敗しました: DB接続エラー');

    //     // 実行
    //     $this->repository->find();
    // }

    // public function testSavePersistsProfile(): void
    // {
    //     // モックの設定
    //     $mockProfile = $this->createMock(Profile::class);

    //     $mockDto = new ProfileDto(
    //         id: 1,
    //         address: '東京都',
    //         displayName: 'テストユーザー',
    //         displayShortName: 'テスト',
    //         from: '東京',
    //         github: 'https://github.com/test',
    //         introduction: '自己紹介文です',
    //         job: 'エンジニア',
    //         likes: ['映画鑑賞', '読書'],
    //         qiita: 'https://qiita.com/test',
    //         skills: ['PHP', 'Laravel', 'AWS'],
    //         summaryIntroduction: '要約文です',
    //         zenn: 'https://zenn.dev/test',
    //     );

    //     $this->mapper
    //         ->expects($this->once())
    //         ->method('toDto')
    //         ->with($mockProfile)
    //         ->willReturn($mockDto);

    //     $this->client
    //         ->expects($this->once())
    //         ->method('putItem')
    //         ->with($this->callback(function ($params) {
    //             return $params['TableName'] === 'profiles'
    //                 && $params['Item']['PK']['S'] === 'PROFILE#ME'
    //                 && $params['Item']['SK']['S'] === 'LATEST'
    //                 && $params['Item']['id']['N'] === '1'
    //                 && $params['Item']['display_name']['S'] === 'テストユーザー'
    //                 && $params['Item']['skills']['SS'] === ['PHP', 'Laravel', 'AWS']
    //                 && $params['Item']['likes']['SS'] === ['映画鑑賞', '読書'];
    //         }));

    //     // 実行
    //     $this->repository->update($mockProfile);

    //     // 例外が発生しなければテスト成功
    //     $this->assertTrue(true);
    // }

    // public function testSaveThrowsRuntimeExceptionWhenDynamoDbExceptionOccurs(): void
    // {
    //     // モックの設定
    //     $mockProfile = $this->createMock(Profile::class);

    //     $mockDto = new ProfileDto(
    //         id: 1,
    //         address: '東京都',
    //         displayName: 'テストユーザー',
    //         displayShortName: 'テスト',
    //         from: '東京',
    //         github: 'https://github.com/test',
    //         introduction: '自己紹介文です',
    //         job: 'エンジニア',
    //         likes: ['映画鑑賞', '読書'],
    //         qiita: 'https://qiita.com/test',
    //         skills: ['PHP', 'Laravel', 'AWS'],
    //         summaryIntroduction: '要約文です',
    //         zenn: 'https://zenn.dev/test',
    //     );

    //     $this->mapper
    //         ->expects($this->once())
    //         ->method('toDto')
    //         ->with($mockProfile)
    //         ->willReturn($mockDto);

    //     $this->client
    //         ->expects($this->once())
    //         ->method('putItem')
    //         ->willThrowException(new DynamoDbException('保存エラー', $this->createMock(\Aws\CommandInterface::class)));

    //     // 例外の期待
    //     $this->expectException(\RuntimeException::class);
    //     $this->expectExceptionMessage('プロフィールの保存に失敗しました: 保存エラー');

    //     // 実行
    //     $this->repository->save($mockProfile);
    // }
}
