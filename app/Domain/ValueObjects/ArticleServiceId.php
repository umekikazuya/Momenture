<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

class ArticleServiceId
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }
}
