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
                        'PK' => ['S' => self::PK],
                        'SK' => ['S' => self::SK],
                    ],
                ]
            );
            if (! isset($result['Item'])) {
                throw new \DomainException('プロフィールが見つかりません。');
            }

            foreach ($result['Item'] as $key => $value) {
                // DynamoDBの値を適切な型に変換
                $item[$key] = $this->parseAttributeValue($value);
            }

            // IDが存在しない場合のみデフォルト値を設定
            $item['id'] = $item['id'] ?? 1;
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
            $item = [
                'PK' => ['S' => self::PK],
                'SK' => ['S' => self::SK],
                'address' => ['S' => $dto->address ?? ''],
                'display_name' => ['S' => $dto->displayName ?? ''],
                'display_short_name' => ['S' => $dto->displayShortName ?? ''],
                'from' => ['S' => $dto->from ?? ''],
                'github' => ['S' => $dto->github ?? ''],
                'introduction' => ['S' => $dto->introduction ?? ''],
                'job' => ['S' => $dto->job ?? ''],
                'qiita' => ['S' => $dto->qiita ?? ''],
                'summary_introduction' => ['S' => $dto->summaryIntroduction ?? ''],
                'zenn' => ['S' => $dto->zenn ?? ''],
            ];

            // 空でない配列のみSSとして追加
            if (! empty($dto->likes)) {
                $item['likes'] = ['SS' => $dto->likes];
            }
            if (! empty($dto->skills)) {
                $item['skills'] = ['SS' => $dto->skills];
            }
            $this->client->putItem(
                [
                    'TableName' => self::TABLE_NAME,
                    'Item' => $item,
                ]
            );

            // 更新後のエンティティを取得して返す
            return $this->find();
        } catch (DynamoDbException $e) {
            throw new \RuntimeException('プロフィールの保存に失敗しました: ' . $e->getMessage(), 500, $e);
        } catch (\Exception $e) {
            throw new \RuntimeException('DynamoDBからの取得に失敗しました: ' . $e->getMessage(), 500, $e);
        }
    }

    /**
     * DynamoDBの属性値を適切な型に変換
     *
     * @param  array $value DynamoDBの属性値
     * @return mixed 変換後の値
     */
    private function parseAttributeValue(array $value): mixed
    {
        return match (true) {
            isset($value['S']) => $value['S'],
            isset($value['SS']) => $value['SS'],
            isset($value['N']) => (int) $value['N'],
            default => null,
        };
    }
}
