<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

class FeaturedPriority
{
    public function __construct(private int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('優先度は1以上である必要があります');
        }
    }

    public function value(): int
    {
        return $this->value;
    }

    public function isHigherThan(FeaturedPriority $other): bool
    {
        return $this->value < $other->value; // 数字が小さいほど優先度高い
    }
}
