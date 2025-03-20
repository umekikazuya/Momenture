<?php

namespace App\Application\UseCases\Article;

use App\Domain\Entities\Article;
use App\Domain\Repositories\ArticleRepositoryInterface;

class FindArticleByIdUseCase implements FindArticleByIdUseCaseInterface
{
    /**
     * 指定された記事リポジトリを利用して、記事検索ユースケースを初期化します。
     */
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * 指定された記事IDに対応する記事を取得する。
     *
     * 渡された記事IDをもとに記事リポジトリから該当する記事を検索し、見つかった記事のオブジェクトを返す。
     * 該当する記事が存在しない場合は null を返す。
     *
     * @param int $articleId 記事ID
     * @return ?Article 該当する記事オブジェクト、または記事が存在しない場合は null
     */
    public function execute(int $articleId): ?Article
    {
        return $this->articleRepository->findById($articleId);
    }
}
