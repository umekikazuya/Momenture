<?php

namespace App\Infrastructure\Clients;

use Aws\DynamoDb\DynamoDbClient;
use Aws\Result;

class AwsDynamoDbClient implements DynamoDbClientInterface
{
    public function __construct(
        private readonly DynamoDbClient $client
    ) {
        $this->client = new DynamoDbClient([
            'region' => config('database.connections.dynamodb.region'),
            'version' => config('database.connections.dynamodb.version'),
            'endpoint' => config('database.connections.dynamodb.endpoint'),
            'credentials' => [
                'key' => config('database.connections.dynamodb.key'),
                'secret' => config('database.connections.dynamodb.secret'),
            ],
        ]);
    }

    public function getItem(array $args): Result
    {
        return $this->client->getItem($args);
    }

    public function putItem(array $args): Result
    {
        return $this->client->putItem($args);
    }
}
