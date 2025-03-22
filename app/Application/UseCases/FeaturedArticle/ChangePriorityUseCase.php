<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\Repositories\FeaturedArticleRepositoryInterface;
use App\Domain\ValueObjects\FeaturedArticleId;
use App\Domain\ValueObjects\FeaturedPriority;

class ChangePriorityUseCase implements ChangePriorityUseCaseInterface
{
    /**
     * ChangePriorityUseCaseの依存性注入用コンストラクタ。
     *
     * このコンストラクタは、注目記事リポジトリを受け取り、優先順位変更処理に必要な依存性を注入します。
     */
    public function __construct(
        private FeaturedArticleRepositoryInterface $repository
    ) {
    }

    /**
     * 指定された注目記事の優先度を変更する。
     *
     * 指定されたIDに対応する注目記事をリポジトリから取得し、
     * 記事が存在しない場合や非アクティブな場合は例外をスローします。
     * 存在し、アクティブな記事の場合は、指定の優先度に更新します。
     *
     * @param FeaturedArticleId $id       対象の注目記事のID
     * @param FeaturedPriority  $priority 設定する新しい優先度
     *
     * @throws \DomainException 対象の記事が存在しない場合、または記事が非アクティブな場合
     */
    public function handle(FeaturedArticleId $id, FeaturedPriority $priority): void
    {
        $featured = $this->repository->findById($id);

        if ($featured === null) {
            throw new \DomainException('注目記事が見つかりません。');
        }

        if (! $featured->isActive()) {
            throw new \DomainException('注目記事は無効です。');
        }

        $this->repository->updatePriority($id, $priority);
    }
}
