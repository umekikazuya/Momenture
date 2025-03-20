<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;

class ArticleService
{
    public function __construct(
        protected ArticleServiceId $id,
        protected ArticleServiceName $name,
    ) {
    }

    public function id(): ArticleServiceId
    {
        return $this->id;
    }

    public function name(): ArticleServiceName
    {
        return $this->name;
    }

    public function updateName(ArticleServiceName $name): void
    {
        $this->name = $name;
    }
}
