<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

final class Skills
{
    /**
     * @var Skill[]
     */
    private array $skills;

    /**
     * @param Skill[] $skills
     */
    public function __construct(array $skills)
    {
        foreach ($skills as $skill) {
            if (! $skill instanceof Skill) {
                throw new \DomainException('Skills に渡す配列は Skill のみを含めてください。');
            }
        }

        $this->skills = $skills;
    }

    /**
     * @return Skill[]
     */
    public function all(): array
    {
        return $this->skills;
    }

    public function contains(Skill $target): bool
    {
        foreach ($this->skills as $skill) {
            if ($skill->equals($target)) {
                return true;
            }
        }

        return false;
    }

    public function isEmpty(): bool
    {
        return count($this->skills) === 0;
    }

    public function toArray(): array
    {
        return $this->skills
            ? array_map(
                static fn (Skill $skill) => $skill->value(),
                $this->skills
            )
            : [];
    }
}
