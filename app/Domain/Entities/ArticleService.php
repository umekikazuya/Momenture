<?php

namespace App\Domain\Entities;

class ArticleService
{
    private int $id;

    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}
