<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\Repositories\FeaturedArticleRepositoryInterface;
use App\Domain\ValueObjects\FeaturedArticleId;

class DeactivateUseCase implements DeactivateUseCaseInterface
{
    /**
     * 注目記事リポジトリを注入し、DeactivateUseCase の新しいインスタンスを生成する。
     *
     * このコンストラクタは、注目記事の取得および無効化処理に用いるリポジトリを内部に保持します。
     */
    public function __construct(
        private FeaturedArticleRepositoryInterface $repository
    ) {
    }

    /**
     * 指定された注目記事IDに基づいて注目記事を非アクティブ状態にします。
     *
     * リポジトリから記事を取得し、該当記事が存在しない場合や既に非アクティブな場合は、ドメイン例外をスローします。
     * 記事が存在しアクティブな場合は、注目記事を非アクティブに更新します。
     *
     * @param FeaturedArticleId $id 非アクティブ化する注目記事の識別子。
     *
     * @throws \DomainException 記事が存在しない場合、または既に非アクティブな場合。
     */
    public function handle(FeaturedArticleId $id): void
    {
        $featured = $this->repository->findById($id);

        if ($featured === null) {
            throw new \DomainException('注目記事が見つかりません。');
        }
        if (! $featured->isActive()) {
            throw new \DomainException('注目記事は既に無効です。');
        }

        $this->repository->deactivate($id);
    }
}
