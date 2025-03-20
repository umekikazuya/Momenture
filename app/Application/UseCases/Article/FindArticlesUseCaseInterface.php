<?php

namespace App\Application\UseCases\Article;

interface FindArticlesUseCaseInterface
{
    /**
 * 与えられたフィルター、ソート条件、ページ番号、および1ページあたりの記事数に基づいて記事を検索し、結果を返します。
 *
 * @param array  $filters 検索条件を指定するフィルターの配列。カテゴリ、タグなど、記事を絞り込む要素が含まれる場合があります。
 * @param string $sort    結果の並び順を指定するソート基準。例として公開日や人気順が考えられます。
 * @param int    $page    取得するページ番号（1以上の整数）。
 * @param int    $perPage 1ページあたりに取得する記事の数。
 *
 * @return array 検索条件に一致する記事の一覧を含む配列。
 */
public function execute(array $filters, string $sort, int $page, int $perPage): array;
}
