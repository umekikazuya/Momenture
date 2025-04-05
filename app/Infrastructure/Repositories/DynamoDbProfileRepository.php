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

    private const PK = 'PROFILE#ME';

    private const SK = 'LATEST';

    public function __construct(
        private readonly DynamoDbClientInterface $client,
        private readonly ProfileMapperInterface $mapper,
    ) {}

    /**
     * {@inheritDoc}
     */
    public function find(): Profile
    {
        try {
            $result = $this->client->getItem([
                'TableName' => self::TABLE_NAME,
                'Key' => [
                    'PK' => ['S' => self::PK],
                    'SK' => ['S' => self::SK],
                ],
            ]);

            if (! isset($result['Item'])) {
                throw new \DomainException('プロフィールが見つかりません。');
            }

            $item = array_map(fn ($v) => $v['S'] ?? ($v['SS'] ?? ''), $result['Item']);
            $dto = ProfileDto::fromArray($item);

            return $this->mapper->toEntity($dto);
        } catch (DynamoDbException $e) {
            throw new \RuntimeException('DynamoDBからの取得に失敗しました: '.$e->getMessage(), 500, $e);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function save(Profile $profile): void
    {
        try {
            $dto = $this->mapper->toDto($profile);
            $this->client->putItem([
                'TableName' => self::TABLE_NAME,
                'Item' => [
                    'PK' => ['S' => self::PK],
                    'SK' => ['S' => self::SK],
                    'id' => ['N' => (string) $dto->id],
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
            ]);
        } catch (DynamoDbException $e) {
            throw new \RuntimeException('プロフィールの保存に失敗しました: '.$e->getMessage(), 500, $e);
        }
    }
}
