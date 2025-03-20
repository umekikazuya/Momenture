<?php

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;

class FindArticlesUseCase implements FindArticlesUseCaseInterface
{
    /**
     * 渡された ArticleRepositoryInterface を内部に保持し、FindArticlesUseCase の新しいインスタンスを生成します。
     */
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * 指定されたフィルター、ソート順、ページ番号、および1ページあたりの件数に基づいて記事の一覧を取得します。
     *
     * @param array $filters 検索条件として使用するフィルターの配列
     * @param string $sort 並び替えの条件を指定する文字列
     * @param int $page 取得するページ番号
     * @param int $perPage 1ページあたりに取得する記事の件数
     *
     * @return array 条件に合致した記事の一覧
     */
    public function execute(array $filters, string $sort, int $page, int $perPage): array
    {
        return $this->articleRepository->findAll($filters, $sort, $page, $perPage);
    }
}
