<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\ValueObjects\FeaturedArticleId;
use App\Domain\ValueObjects\FeaturedPriority;

interface ChangePriorityUseCaseInterface
{
    /**
     * 注目記事の優先度を更新
     *
     * @throws \DomainException 更新不可時
     */
    public function handle(FeaturedArticleId $id, FeaturedPriority $priority): void;
}
