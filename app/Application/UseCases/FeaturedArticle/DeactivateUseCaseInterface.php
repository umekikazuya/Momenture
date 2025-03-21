<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\ValueObjects\FeaturedArticleId;

interface DeactivateUseCaseInterface
{
    /**
     * 注目記事を無効化
     *
     * @throws \DomainException 無効化不可時
     */
    public function handle(FeaturedArticleId $id): void;
}
