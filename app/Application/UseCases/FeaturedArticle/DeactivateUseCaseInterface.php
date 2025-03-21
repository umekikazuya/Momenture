<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\ValueObjects\FeaturedArticleId;

interface DeactivateUseCaseInterface
{
    /**
     * 注目記事を無効化
     */
    public function handle(FeaturedArticleId $id): void;
}
