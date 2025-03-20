<?php

namespace App\Application\UseCases\Article;

use App\Domain\Entities\Article;
use App\Domain\Repositories\ArticleRepositoryInterface;

class FindArticleByIdUseCase implements FindArticleByIdUseCaseInterface
{
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    public function execute(int $articleId): ?Article
    {
        return $this->articleRepository->findById($articleId);
    }
}
