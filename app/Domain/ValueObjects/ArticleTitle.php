<?php

namespace App\Domain\ValueObjects;

class ArticleTitle
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty(trim($value))) {
            throw new \DomainException('記事タイトルは空白にできません。');
        }
        if (mb_strlen($value) > 100) {
            throw new \DomainException('記事タイトルは100文字以内にしてください。');
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
