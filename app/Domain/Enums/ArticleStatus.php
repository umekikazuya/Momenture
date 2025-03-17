<?php

namespace App\Domain\Enums;

enum ArticleStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    public function canBePublished(): bool
    {
        return $this === self::DRAFT;
    }
}
