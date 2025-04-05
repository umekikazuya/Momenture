<?php

namespace App\Infrastructure\Clients;

use Aws\DynamoDb\DynamoDbClient;
use Aws\Result;

class AwsDynamoDbClient implements DynamoDbClientInterface
{
    public function __construct(
        private readonly DynamoDbClient $client
    ) {
        $this->client = new DynamoDbClient(
            [
            'region' => config('services.dynamodb.region'),
            'version' => 'latest',
            'endpoint' => app()->environment('local') ? env('DYNAMODB_ENDPOINT') : null,
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
            ]
        );
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
