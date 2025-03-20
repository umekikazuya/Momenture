<?php

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;

class FindArticlesUseCase implements FindArticlesUseCaseInterface
{
    /**
     * コンストラクタ。
     *
     * ArticleRepositoryInterface のインスタンスを注入し、記事検索ユースケースを初期化します。
     */
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * 指定された条件に基づいて記事の一覧を取得する。
     *
     * 与えられたフィルター、ソート順、ページ番号、及び1ページあたりの件数に基づいて記事の一覧を検索し、
     * 結果を配列として返します。
     *
     * @param array $filters 記事検索のフィルター条件の配列
     * @param string $sort   記事の表示順を指定する文字列
     * @param int $page      取得するページ番号（1からの数値）
     * @param int $perPage   1ページあたりに取得する記事の件数
     * @return array 検索条件に一致する記事の一覧
     */
    public function execute(array $filters, string $sort, int $page, int $perPage): array
    {
        return $this->articleRepository->findAll($filters, $sort, $page, $perPage);
    }
}
