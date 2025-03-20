<?php

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;

class FindArticlesUseCase implements FindArticlesUseCaseInterface
{
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    public function execute(array $filters, string $sort, int $page, int $perPage): array
    {
        return $this->articleRepository->findAll($filters, $sort, $page, $perPage);
    }
}
