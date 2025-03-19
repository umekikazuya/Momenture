<?php

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;

class SearchArticlesUseCase implements SearchArticlesUseCaseInterface
{
    public function __construct(private ArticleRepositoryInterface $articleRepository) {}

    public function execute(string $keyword, ?int $serviceId = null, ?int $tagId = null): array
    {
        return $this->articleRepository->search($keyword, $serviceId, $tagId);
    }
}
