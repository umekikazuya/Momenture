<?php

namespace App\Application\UseCases\Article;

interface FindArticlesUseCaseInterface
{
    /**
 * 指定された条件に基づいて記事一覧を検索し、結果を返す。
 *
 * 指定されたフィルター、ソート順、ページ番号、および1ページあたりの件数を元に記事を検索し、該当する記事の配列を返します。
 *
 * @param array $filters 検索条件を定義するフィルターの配列
 * @param string $sort 記事の並び順を指定する文字列
 * @param int $page 現在のページ番号
 * @param int $perPage 1ページあたりの表示件数
 *
 * @return array 検索条件に一致した記事一覧の配列
 */
public function execute(array $filters, string $sort, int $page, int $perPage): array;
}
