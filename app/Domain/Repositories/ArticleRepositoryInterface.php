<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Article;
use App\Domain\Enums\ArticleStatus;

interface ArticleRepositoryInterface
{
    /**
     * 記事IDから記事を取得
     */
    public function findById(int $id): ?Article;

    /**
     * 記事ステータスから記事を取得
     *
     * @return Article[]
     */
    public function findByStatus(ArticleStatus $status): array;

    /**
     * 記事を保存
     */
    public function save(Article $article): void;

    /**
     * 記事を削除
     */
    public function delete(Article $article): void;
}
