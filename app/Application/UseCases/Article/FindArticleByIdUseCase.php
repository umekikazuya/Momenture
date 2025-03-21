<?php

namespace App\Application\UseCases\Article;

use App\Domain\Entities\Article;
use App\Domain\Repositories\ArticleRepositoryInterface;

class FindArticleByIdUseCase implements FindArticleByIdUseCaseInterface
{
    /**
     * コンストラクタ
     *
     * ArticleRepositoryInterface の依存性注入を行い、クラスのインスタンスを初期化します。
     */
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * 指定された記事IDに対する記事を取得する。
     *
     * 与えられた記事IDで記事を検索し、該当する記事が存在する場合はその記事のインスタンスを、存在しない場合は null を返します。
     *
     * @param  int $articleId 記事の識別子
     * @return Article|null 検索結果の文章記事または記事が見つからない場合は null
     */
    public function execute(int $articleId): ?Article
    {
        return $this->articleRepository->findById($articleId);
    }
}
