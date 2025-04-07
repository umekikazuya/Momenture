<?php

namespace App\Infrastructure\Clients;

use Aws\Result;

interface DynamoDbClientInterface
{
    /**
     * DynamoDB からアイテムを取得
     *
     * @param  array $args 取得条件
     * @return Result DynamoDB の結果オブジェクト
     */
    public function getItem(array $args): Result;

    /**
     * DynamoDB にアイテムを追加
     *
     * @param  array $args 保存するアイテムデータ
     * @return Result DynamoDB の結果オブジェクト
     */
    public function putItem(array $args): Result;
}
