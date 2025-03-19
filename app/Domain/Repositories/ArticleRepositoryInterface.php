<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Article;

interface ArticleRepositoryInterface
{
    /**
     * 記事IDから記事を取得
     */
    public function findById(int $id): ?Article;

    /**
     * キーワードから記事を検索
     *
     * @return Article[]
     */
    public function search(string $keyword, ?int $serviceId = null, ?int $tagId = null): array;

    /**
     * 記事を全件取得
     *
     * @return Article[]
     */
    public function findAll(array $filters, string $sort, int $page, int $perPage): array;

    /**
     * 記事を保存
     */
    public function save(Article $article): void;

    /**
     * 記事を削除(論理削除)
     */
    public function delete(Article $article): void;

    /**
     * 記事を強制削除
     */
    public function forceDelete(Article $article): void;

    /**
     * 記事を復元
     */
    public function restore(Article $article): void;

    /**
     * 記事IDから削除済みの記事を取得
     */
    public function findTrashedById(int $id): ?Article;
}
