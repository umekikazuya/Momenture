<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

class ArticleServiceName
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty(trim($value))) {
            throw new \DomainException('サービス名は空白にできません。');
        }
        if (mb_strlen($value) > 100) {
            throw new \DomainException('サービス名は100文字以内にしてください。');
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
