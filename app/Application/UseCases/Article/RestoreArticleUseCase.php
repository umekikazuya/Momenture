<?php

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;
use DomainException;

class RestoreArticleUseCase implements RestoreArticleUseCaseInterface
{
    public function __construct(private ArticleRepositoryInterface $articleRepository) {}

    public function execute(int $articleId): void
    {
        $article = $this->articleRepository->findTrashedById($articleId);

        if (!$article) {
            throw new DomainException("削除済みの記事が見つかりません。");
        }

        $this->articleRepository->restore($article);
    }
}
