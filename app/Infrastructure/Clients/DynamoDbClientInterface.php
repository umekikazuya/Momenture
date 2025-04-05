<?php

namespace App\Infrastructure\Clients;

use Aws\Result;

interface DynamoDbClientInterface
{
    public function getItem(array $args): Result;

    public function putItem(array $args): Result;
}
