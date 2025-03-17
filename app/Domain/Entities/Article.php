<?php

namespace App\Domain\Entities;

use App\Domain\Enums\ArticleStatus;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleTitle;

class Article
{
    public function __construct(
        private int $id,
        private ArticleTitle $title,
        private ArticleStatus $status,
        private ArticleService $service,
        private \DateTimeImmutable $createdAt,
        private \DateTimeImmutable $updatedAt,
        private ?ArticleLink $link = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->status = $status;
        $this->service = $service;
        $this->link = $link;
        $this->createdAt = new \DateTimeImmutable;
        $this->updatedAt = new \DateTimeImmutable;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function title(): ArticleTitle
    {
        return $this->title;
    }

    public function service(): ArticleService
    {
        return $this->service;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function isPublished(): bool
    {
        return $this->status === ArticleStatus::PUBLISHED;
    }

    public function isDraft(): bool
    {
        return $this->status === ArticleStatus::DRAFT;
    }

    public function hasLink(): bool
    {
        return $this->link !== null;
    }

    public function link(): ?ArticleLink
    {
        return $this->link;
    }

    public function publish(): void
    {
        if (! $this->status->canBePublished()) {
            throw new \DomainException('記事を公開できません。');
        }
        $this->status = ArticleStatus::PUBLISHED;
        $this->updatedAt = new \DateTimeImmutable;
    }

    public function updateTitle(ArticleTitle $title): void
    {
        $this->title = $title;
        $this->updatedAt = new \DateTimeImmutable;
    }

    public function updateLink(?ArticleLink $link): void
    {
        $this->link = $link;
        $this->updatedAt = new \DateTimeImmutable;
    }
}
