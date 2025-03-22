<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\Repositories\FeaturedArticleRepositoryInterface;
use App\Domain\ValueObjects\FeaturedArticleId;
use App\Domain\ValueObjects\FeaturedPriority;

class AssignArticleUseCase implements AssignArticleUseCaseInterface
{
    private const DEFAULT_MAX_FEATURED_COUNT = 5;

    /**
     * コンストラクタ
     *
     * 指定された FeaturedArticleRepository の実装を利用して、注目記事のリポジトリを初期化します。
     * オプションで注目記事の最大許容数を設定でき、未指定の場合は self::DEFAULT_MAX_FEATURED_COUNT が使用されます。
     */
    public function __construct(
        private FeaturedArticleRepositoryInterface $repository,
        private int $maxFeaturedCount = self::DEFAULT_MAX_FEATURED_COUNT
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function handle(FeaturedArticleId $id, FeaturedPriority $priority): void
    {
        // 上限チェック
        if ($this->repository->countActive() >= $this->maxFeaturedCount) {
            throw new \DomainException('注目記事の上限に達しています。');
        }

        $this->repository->add($id->value(), $priority);
    }
}
