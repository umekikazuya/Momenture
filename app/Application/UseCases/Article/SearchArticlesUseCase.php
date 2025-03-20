<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;

class SearchArticlesUseCase implements SearchArticlesUseCaseInterface
{
    /**
     * 新しい SearchArticlesUseCase インスタンスを生成するコンストラクタ。
     *
     * ArticleRepositoryInterface を注入することで、記事検索に必要なリポジトリへのアクセスを提供します。
     */
    public function __construct(
        private ArticleRepositoryInterface $articleRepository
    ) {
    }

    /**
     * キーワード、サービスID、タグIDに基づいて記事を検索し、結果の配列を返します。
     *
     * 指定されたパラメータにより記事リポジトリの検索メソッドを呼び出します。
     *
     * @param string|null $keyword 検索に使用するキーワード（省略可能）。
     * @param int|null $serviceId サービスを識別するID（省略可能）。
     * @param int|null $tagId タグを識別するID（省略可能）。
     * @return array 記事検索の結果を含む配列。
     */
    public function execute(?string $keyword = null, ?int $serviceId = null, ?int $tagId = null): array
    {
        return $this->articleRepository->search($keyword, $serviceId, $tagId);
    }
}
