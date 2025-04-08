<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

final class Likes
{
    /**
     * @var Like[]
     */
    private array $likes;

    /**
     * @param Like[] $likes
     */
    public function __construct(array $likes)
    {
        foreach ($likes as $like) {
            if (! $like instanceof Like) {
                throw new \DomainException('Likes に渡す配列は Like のみを含めてください。');
            }
        }

        $this->likes = $likes;
    }

    /**
     * @return Like[]
     */
    public function all(): array
    {
        return $this->likes;
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return array_map(fn (Like $like) => $like->value(), $this->likes);
    }
}
