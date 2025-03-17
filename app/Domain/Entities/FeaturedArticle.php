<?php

namespace App\Domain\Entities;

class FeaturedArticle
{
    private int $id;
    private Article $article;
    private \DateTimeImmutable $startDate;
    private ?\DateTimeImmutable $endDate;

    public function __construct(
        int $id,
        Article $article,
        \DateTimeImmutable $startDate,
        ?\DateTimeImmutable $endDate = null
    ) {
        $this->id = $id;
        $this->article = $article;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function isActive(): bool
    {
        return $this->endDate === null || $this->endDate > new \DateTimeImmutable();
    }
}
