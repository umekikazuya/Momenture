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
     * 指定された FeaturedArticleRepository の実装を利用して、フィーチャー記事のリポジトリを初期化します。
     * オプションでフィーチャー記事の最大許容数を設定でき、未指定の場合は self::DEFAULT_MAX_FEATURED_COUNT が使用されます。
     */
    public function __construct(
        private FeaturedArticleRepositoryInterface $repository,
        private int $maxFeaturedCount = self::DEFAULT_MAX_FEATURED_COUNT
    ) {
    }

    /**
     * 指定された記事を注目記事として割り当てる。
     *
     * 現在の注目記事数が上限に達している場合、DomainException をスローする。上限に達していなければ、
     * 指定された記事IDと優先度を用いて記事を注目記事リポジトリに追加する。
     *
     * @param FeaturedArticleId $articleId 注目記事として割り当てる記事のID
     * @param FeaturedPriority  $priority  記事に設定する優先度
     *
     * @throws \DomainException 注目記事の上限に達している場合にスローされる
     */
    public function handle(FeaturedArticleId $articleId, FeaturedPriority $priority): void
    {
        // 上限チェック
        if ($this->repository->countActive() >= $this->maxFeaturedCount) {
            throw new \DomainException('注目記事の上限に達しています。');
        }

        $this->repository->add($articleId->value(), $priority);
    }
}
