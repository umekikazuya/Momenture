<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\Entities\FeaturedArticle;
use App\Domain\Repositories\FeaturedArticleRepositoryInterface;

class FindAllUseCase implements FindAllUseCaseInterface
{
    public function __construct(
        private FeaturedArticleRepositoryInterface $repository
    ) {
    }

    /**
     * 有効な注目記事一覧を取得（優先度順）
     *
     * @return FeaturedArticle[]
     */
    public function handle(): array {
        return $this->repository->findAll();
    }
}
