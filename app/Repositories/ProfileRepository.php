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
        $result = $this->client->getItem([
            'TableName' => $this->tableName,
            'Key' => ['PK' => ['S' => $id]],
        ]);

        $data = $result['Item'] ?? null;

        if (! $data) {
            return null;
        }

        $attributes = $this->fromDynamoDbFormat($data);

        return new Profile([
            'id' => $attributes['PK'],
            'displayName' => $attributes['field_display_name'],
            'introduction' => $attributes['field_introduction'],
            'likes' => $attributes['field_like'],
            'updatedAt' => $attributes['updated_at'],
        ]);
    }

    public function save(Profile $profile): void
    {
        $item = $this->toDynamoDbFormat([
            'PK' => $profile->id,
            'field_display_name' => $profile->displayName,
            'field_introduction' => $profile->introduction,
            'field_like' => $profile->likes,
            'updated_at' => $profile->updatedAt,
        ]);

        $this->client->putItem([
            'TableName' => $this->tableName,
            'Item' => $item,
        ]);
    }

    public function delete(string $id): void
    {
        $this->client->deleteItem([
            'TableName' => $this->tableName,
            'Key' => ['PK' => ['S' => $id]],
        ]);
    }

    /**
     * DynamoDB形式をPHP形式に変換
     */
    private function fromDynamoDbFormat(array $data): array
    {
        return array_map(function ($value) {
            if (isset($value['S'])) {
                return $value['S'];
            } elseif (isset($value['L'])) {
                return array_map(fn ($v) => $this->fromDynamoDbFormat($v), $value['L']);
            }

            return $value;
        }, $data);
    }

    /**
     * PHP形式をDynamoDB形式に変換
     */
    private function toDynamoDbFormat(array $data): array
    {
        return array_map(function ($value) {
            if (is_string($value)) {
                return ['S' => $value];
            } elseif (is_array($value)) {
                return ['L' => array_map(fn ($v) => $this->toDynamoDbFormat($v), $value)];
            }

            return $value;
        }, $data);
    }
}
