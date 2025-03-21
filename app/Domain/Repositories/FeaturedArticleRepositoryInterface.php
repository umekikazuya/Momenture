<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\FeaturedArticle;
use App\Domain\ValueObjects\FeaturedArticleId;
use App\Domain\ValueObjects\FeaturedPriority;

interface FeaturedArticleRepositoryInterface
{
    /**
     * 注目記事一覧を取得（優先度順）
     *
     * @return FeaturedArticle[]
     */
    public function findAll(): array;

    /**
     * 注目記事を追加（記事ID、優先度）
     */
    public function add(int $articleId, FeaturedPriority $priority): void;

    /**
     * 優先度を更新
     */
    public function updatePriority(FeaturedArticleId $id, FeaturedPriority $priority): void;

    /**
     * 注目記事を無効化（is_active = false）
     */
    public function deactivate(FeaturedArticleId $id): void;

    /**
     * 注目記事を取得
     */
    public function findById(FeaturedArticleId $id): ?FeaturedArticle;

    /**
     * 登録数取得（上限チェック用）
     */
    public function countActive(): int;
}
