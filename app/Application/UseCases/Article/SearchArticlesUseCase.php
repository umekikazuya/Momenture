<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;

class SearchArticlesUseCase implements SearchArticlesUseCaseInterface
{
    public function __construct(
        private ArticleRepositoryInterface $articleRepository
    ) {
    }

    public function execute(?string $keyword = null, ?int $serviceId = null, ?int $tagId = null): array
    {
        return $this->articleRepository->search($keyword, $serviceId, $tagId);
    }
}
