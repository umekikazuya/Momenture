<?php

namespace App\Application\UseCases\Article;

interface FindArticlesUseCaseInterface
{
    /**
 * 指定されたフィルタ、ソート順、ページ番号、および1ページあたりの記事数に基づいて記事を検索し、記事のリストを返す。
 *
 * 与えられた条件に従って記事を抽出します。
 *
 * @param array $filters 記事検索に使用するフィルタ条件
 * @param string $sort 記事の並び順を指定する文字列
 * @param int $page 取得するページ番号
 * @param int $perPage 1ページあたりに取得する記事数
 * @return array 検索結果の文章リスト
 */
public function execute(array $filters, string $sort, int $page, int $perPage): array;
}
