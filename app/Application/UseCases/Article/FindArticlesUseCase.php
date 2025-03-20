<?php

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;

class FindArticlesUseCase implements FindArticlesUseCaseInterface
{
    /**
     * FindArticlesUseCase のコンストラクタ。
     *
     * ArticleRepositoryInterface を受け取り、記事リポジトリへの依存性を注入します。
     */
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * 指定された条件に基づいて記事一覧を取得する。
     *
     * 指定されたフィルタ、ソート順、ページ番号、1ページあたりの件数により記事を検索し、一致する記事の配列を返します。
     *
     * @param array $filters 検索条件の配列
     * @param string $sort 結果のソート順を示す文字列
     * @param int $page ページ番号（1ページ目は1）
     * @param int $perPage 1ページあたりの表示件数
     *
     * @return array 検索結果として一致する記事の一覧
     */
    public function execute(array $filters, string $sort, int $page, int $perPage): array
    {
        return $this->articleRepository->findAll($filters, $sort, $page, $perPage);
    }
}
