<?php

namespace App\Domain\Entities;

class FeaturedArticle
{
    public function __construct(
        private int $id,
        private Article $article,
        private \DateTimeImmutable $startDate,
        private ?\DateTimeImmutable $endDate = null
    ) {
        $this->id = $id;
        $this->article = $article;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function isActive(): bool
    {
        return $this->endDate === null || $this->endDate > new \DateTimeImmutable;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function article(): Article
    {
        return $this->article;
    }

    public function startDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function endDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }
}
