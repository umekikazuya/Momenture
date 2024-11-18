<?php

namespace App\Models;

use Aws\DynamoDb\DynamoDbClient;

abstract class DynamoDbModel
{
    protected static $tableName;

    protected static ?DynamoDbClient $client = null;

    /**
     * DynamoDBクライアント
     */
    protected static function getClient(): DynamoDbClient
    {
        if (! self::$client) {
            self::$client = new DynamoDbClient([
                'region' => env('AWS_DEFAULT_REGION'),
                'version' => 'latest',
                'endpoint' => env('DYNAMODB_ENDPOINT'),
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);
        }

        return self::$client;
    }

    /**
     * アイテムを取得
     */
    public static function find(array $key): ?array
    {
        $result = self::getClient()->getItem([
            'TableName' => static::$tableName,
            'Key' => $key,
        ]);

        return $result['Item'] ?? null;
    }

    /**
     * アイテムを保存
     */
    public static function save(array $item): void
    {
        self::getClient()->putItem([
            'TableName' => static::$tableName,
            'Item' => $item,
        ]);
    }

    /**
     * アイテムを削除
     */
    public static function delete(array $key): void
    {
        self::getClient()->deleteItem([
            'TableName' => static::$tableName,
            'Key' => $key,
        ]);
    }

    /**
     * DynamoDBクエリ
     */
    public static function query(array $params): array
    {
        $result = self::getClient()->query(array_merge(['TableName' => static::$tableName], $params));

        return $result['Items'] ?? [];
    }
}
