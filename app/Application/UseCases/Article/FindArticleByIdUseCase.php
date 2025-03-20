<?php

namespace App\Application\UseCases\Article;

use App\Domain\Entities\Article;
use App\Domain\Repositories\ArticleRepositoryInterface;

class FindArticleByIdUseCase implements FindArticleByIdUseCaseInterface
{
    /**
     * FindArticleByIdUseCase の新しいインスタンスを初期化します。
     *
     * コンストラクタは、記事IDに基づいて記事を検索するためのリポジトリ依存性 (ArticleRepositoryInterface) を注入します。
     */
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * 指定された記事IDに対応する記事を取得する。
     *
     * 記事リポジトリから該当する記事を検索し、Articleオブジェクトを返します。
     * 該当する記事が存在しない場合はnullを返します。
     *
     * @param int $articleId 記事の識別子
     * @return Article|null 該当する記事が存在すればArticleオブジェクト、存在しなければnull
     */
    public function execute(int $articleId): ?Article
    {
        return $this->articleRepository->findById($articleId);
    }
}
