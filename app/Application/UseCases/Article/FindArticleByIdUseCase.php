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
     * {@inheritDoc}
     */
    public function execute(int $articleId): Article
    {
        return $this->articleRepository->findById($articleId);
    }
}
