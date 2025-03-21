<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\Repositories\FeaturedArticleRepositoryInterface;
use App\Domain\ValueObjects\FeaturedArticleId;
use App\Domain\ValueObjects\FeaturedPriority;

class ChangePriorityUseCase implements ChangePriorityUseCaseInterface
{
    public function __construct(
        private FeaturedArticleRepositoryInterface $repository
    ) {
    }

    public function handle(FeaturedArticleId $id, FeaturedPriority $priority): void
    {
        $featured = $this->repository->findById($id);

        if ($featured === null) {
            throw new \DomainException('注目記事が見つかりません。');
        }

        $this->repository->updatePriority($id, $priority);
    }
}
