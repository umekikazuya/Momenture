<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\Repositories\FeaturedArticleRepositoryInterface;
use App\Domain\ValueObjects\FeaturedPriority;

class AssignArticleUseCase implements AssignArticleUseCaseInterface
{
    private const DEFAULT_MAX_FEATURED_COUNT = 5;

    public function __construct(
        private FeaturedArticleRepositoryInterface $repository,
        private int $maxFeaturedCount = self::DEFAULT_MAX_FEATURED_COUNT
    ) {
    }

    public function handle(int $articleId, FeaturedPriority $priority): void
    {
        // 上限チェック
        if ($this->repository->countActive() >= $this->maxFeaturedCount) {
            throw new \DomainException('注目記事の上限に達しています。');
        }

        $this->repository->add($articleId, $priority);
    }
}
