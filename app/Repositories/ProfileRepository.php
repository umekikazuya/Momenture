<?php

namespace App\Repositories;

use App\Models\Profile;
use App\Repositories\Contracts\ProfileRepositoryInterface;
use Aws\DynamoDb\DynamoDbClient;

class ProfileRepository implements ProfileRepositoryInterface
{
    private DynamoDbClient $client;

    private string $tableName;

    public function __construct()
    {
        $this->client = app(DynamoDbClient::class);
        $this->tableName = 'momenture';
    }

    public function findById(string $id): ?Profile
    {
        $result = $this->client->getItem(
            [
            'TableName' => $this->tableName,
            'Key' => ['PK' => ['S' => $id]],
            ]
        );

        $data = $result['Item'] ?? null;

        if (! $data) {
            return null;
        }

        $attributes = $this->fromDynamoDbFormat($data);

        return new Profile(
            [
            'id' => $attributes['PK'],
            'displayName' => $attributes['display_name'],
            'displayShortName' => $attributes['display_short_name'] ?? null,
            'address' => $attributes['address'] ?? null,
            'from' => $attributes['from'] ?? null,
            'github' => $attributes['github'] ?? null,
            'introduction' => $attributes['introduction'] ?? null,
            'job' => $attributes['job'] ?? null,
            'likes' => $attributes['like'] ?? [],
            'qiita' => $attributes['qiita'] ?? null,
            'skills' => $attributes['skill'] ?? [],
            'summaryIntroduction' => $attributes['summary_introduction'] ?? null,
            'zenn' => $attributes['zenn'] ?? null,
            'updatedAt' => $attributes['updated_at'] ?? null,
            ]
        );
    }

    public function save(Profile $profile): void
    {
        $item = $this->toDynamoDbFormat(
            [
                'PK' => $profile->id,
                'display_name' => $profile->displayName,
                'display_short_name' => $profile->displayShortName,
                'address' => $profile->address,
                'from' => $profile->from,
                'github' => $profile->github,
                'introduction' => $profile->introduction,
                'job' => $profile->job,
                'like' => $profile->likes,
                'qiita' => $profile->qiita,
                'skill' => $profile->skills,
                'summary_introduction' => $profile->summaryIntroduction,
                'zenn' => $profile->zenn,
                'updated_at' => $profile->updatedAt,
            ]
        );

        $this->client->putItem(
            [
            'TableName' => $this->tableName,
            'Item' => $item,
            ]
        );
    }

    public function delete(string $id): void
    {
        $this->client->deleteItem(
            [
            'TableName' => $this->tableName,
            'Key' => ['PK' => ['S' => $id]],
            ]
        );
    }

    /**
     * DynamoDB形式をPHP形式に変換
     */
    private function fromDynamoDbFormat(array $data): array
    {
        return array_map(
            function ($value) {
                if (isset($value['S'])) {
                    return $value['S'];
                } elseif (isset($value['N'])) {
                    return (float) $value['N'];
                } elseif (isset($value['L'])) {
                    // リストの場合、要素を個別に変換
                    return array_map(
                        function ($v) {
                            if (isset($v['S'])) {
                                return $v['S'];
                            } elseif (isset($v['N'])) {
                                return (float) $v['N'];
                            } elseif (isset($v['NULL'])) {
                                return null;
                            }

                            throw new \InvalidArgumentException(
                                'Unsupported DynamoDB data type in list: ' . json_encode($v)
                            );
                        },
                        $value['L']
                    );
                } elseif (isset($value['NULL'])) {
                    return null;
                }

                throw new \InvalidArgumentException('Unsupported DynamoDB data type: ' . json_encode($value));
            },
            $data
        );
    }

    /**
     * PHP形式をDynamoDB形式に変換
     */
    private function toDynamoDbFormat(array $data): array
    {
        return array_map(
            function ($value) {
                if (is_null($value)) {
                    return ['NULL' => true];
                } elseif (is_string($value)) {
                    return ['S' => $value];
                } elseif (is_numeric($value)) {
                    return ['N' => (string) $value];
                } elseif (is_array($value)) {
                    // 配列の場合はスカラ値を判定して変換
                    return ['L' => array_map(
                        function ($v) {
                            if (is_null($v)) {
                                return ['NULL' => true];
                            } elseif (is_string($v)) {
                                return ['S' => $v];
                            } elseif (is_numeric($v)) {
                                return ['N' => (string) $v];
                            }
                            throw new \InvalidArgumentException('Unsupported array element type');
                        },
                        $value
                    )];
                }

                throw new \InvalidArgumentException('Unsupported data type');
            },
            $data
        );
    }
}
