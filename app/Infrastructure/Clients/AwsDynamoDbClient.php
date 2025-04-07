<?php

namespace App\Infrastructure\Clients;

use Aws\DynamoDb\DynamoDbClient;
use Aws\Result;

class AwsDynamoDbClient implements DynamoDbClientInterface
{
    public function __construct(
        private readonly DynamoDbClient $client
    ) {
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
