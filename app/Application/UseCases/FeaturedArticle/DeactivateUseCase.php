<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\Repositories\FeaturedArticleRepositoryInterface;
use App\Domain\ValueObjects\FeaturedArticleId;

class DeactivateUseCase implements DeactivateUseCaseInterface
{
    public function __construct(
        private FeaturedArticleRepositoryInterface $repository
    ) {
    }

    public function handle(FeaturedArticleId $id): void
    {
        $featured = $this->repository->findById($id);

        if ($featured === null) {
            throw new \DomainException('注目記事が見つかりません。');
        }

        $this->repository->deactivate($id);
    }
}
