<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

final class Skill
{
    public function __construct(private string $value)
    {
        if (trim($value) === '') {
            throw new \DomainException('Skill は空にできません。');
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(Skill $other): bool
    {
        return $this->value === $other->value();
    }
}
