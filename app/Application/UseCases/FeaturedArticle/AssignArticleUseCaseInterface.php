<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\ValueObjects\FeaturedArticleId;
use App\Domain\ValueObjects\FeaturedPriority;

interface AssignArticleUseCaseInterface
{
    /**
     * 注目記事を登録（上限チェック付き）
     *
     * @param FeaturedArticleId $id       注目記事のID
     * @param FeaturedPriority  $priority 注目記事の優先度
     *
     * @throws \DomainException 上限超過・登録不可時
     * @throws \RuntimeException データベースエラー時
     */
    public function handle(FeaturedArticleId $id, FeaturedPriority $priority): void;
}
