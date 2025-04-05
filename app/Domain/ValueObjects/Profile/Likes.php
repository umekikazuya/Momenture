<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

use Illuminate\Support\Collection;

final class Likes
{
    /** @var Like[] */
    private array $likes;

    /**
     * @param  Like[]  $likes
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

    public function contains(Like $target): bool
    {
        foreach ($this->likes as $like) {
            if ($like->equals($target)) {
                return true;
            }
        }

        return false;
    }

    public function isEmpty(): bool
    {
        return count($this->likes) === 0;
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return array_map(fn (Skill $likes) => $likes->value(), $this->likes);
    }

    public function toCollection(): Collection
    {
        return collect($this->likes);
    }
}
