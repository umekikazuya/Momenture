<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Application\DTOs\ProfileDto;
use App\Application\Mappers\ProfileMapperInterface;
use App\Domain\Entities\Profile;
use App\Domain\Repositories\ProfileRepositoryInterface;
use App\Infrastructure\Clients\DynamoDbClientInterface;
use Aws\DynamoDb\Exception\DynamoDbException;

class DynamoDbProfileRepository implements ProfileRepositoryInterface
{
    private const TABLE_NAME = 'profiles';

    private const PK_NAME = 'PK';
    private const SK_NAME = 'SK';
    private const PK_VALUE = 'PROFILE#ME';
    private const SK_VALUE = 'LATEST';

    public function __construct(
        private readonly DynamoDbClientInterface $client,
        private readonly ProfileMapperInterface $mapper,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function find(): Profile
    {
        try {
            $result = $this->client->getItem(
                [
                    'TableName' => self::TABLE_NAME,
                    'Key' => [
                        self::PK_NAME => ['S' => self::PK_VALUE],
                        self::SK_NAME => ['S' => self::SK_VALUE],
                    ],
                ]
            );

            if (! isset($result['Item'])) {
                throw new \DomainException('プロフィールが見つかりません。');
            }

            $item = array_map(fn ($v) => $v['S'] ?? ($v['SS'] ?? ''), $result['Item']);
            $item['id'] = 1;
            $dto = ProfileDto::fromArray($item);

            return $this->mapper->toEntity($dto);
        } catch (DynamoDbException $e) {
            throw new \RuntimeException('DynamoDBからの取得に失敗しました: ' . $e->getMessage(), 500, $e);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function update(Profile $profile): Profile
    {
        try {
            $dto = $this->mapper->toDto($profile);
            $this->client->putItem(
                [
                    'TableName' => self::TABLE_NAME,
                    'Item' => [
                        self::PK_NAME => ['S' => self::PK_VALUE],
                        self::SK_NAME => ['S' => self::SK_VALUE],
                        'address' => ['S' => $dto->address ?? ''],
                        'display_name' => ['S' => $dto->displayName ?? ''],
                        'display_short_name' => ['S' => $dto->displayShortName ?? ''],
                        'from' => ['S' => $dto->from ?? ''],
                        'github' => ['S' => $dto->github ?? ''],
                        'introduction' => ['S' => $dto->introduction ?? ''],
                        'job' => ['S' => $dto->job ?? ''],
                        'likes' => ['SS' => $dto->likes],
                        'qiita' => ['S' => $dto->qiita ?? ''],
                        'skills' => ['SS' => $dto->skills],
                        'summary_introduction' => ['S' => $dto->summaryIntroduction ?? ''],
                        'zenn' => ['S' => $dto->zenn ?? ''],
                    ],
                ]
            );

            return $profile;
        } catch (DynamoDbException $e) {
            throw new \RuntimeException('プロフィールの保存に失敗しました: ' . $e->getMessage(), 500, $e);
        }
    }
}
