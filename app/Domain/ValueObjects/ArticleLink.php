<?php

namespace App\Domain\ValueObjects;

class ArticleLink
{
    private string $url;

    public function __construct(string $url)
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \DomainException('無効なURLです: ' . $url);
        }
        $this->url = $url;
    }

    public function value(): string
    {
        return $this->url;
    }
}
