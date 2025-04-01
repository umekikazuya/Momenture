<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

final class Like
{
    public function __construct(private string $value)
    {
        if (trim($value) === '') {
            throw new \DomainException('Like は空にできません。');
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(Like $other): bool
    {
        return $this->value === $other->value();
    }
}
