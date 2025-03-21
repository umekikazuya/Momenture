<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\ValueObjects\FeaturedPriority;

interface AssignArticleUseCaseInterface
{
    /**
     * 注目記事を登録（上限チェック付き）
     *
     * @throws \DomainException 上限超過・登録不可時
     */
    public function handle(int $articleId, FeaturedPriority $priority): void;
}
