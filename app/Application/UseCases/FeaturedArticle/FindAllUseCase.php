<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\Entities\FeaturedArticle;
use App\Domain\Repositories\FeaturedArticleRepositoryInterface;

class FindAllUseCase implements FindAllUseCaseInterface
{
    /**
     * コンストラクタ。
     *
     * 指定された FeaturedArticleRepositoryInterface の実装を内部プロパティに保持します。
     */
    public function __construct(
        private FeaturedArticleRepositoryInterface $repository
    ) {
    }

    /**
     * 有効な注目記事一覧を取得（優先度順）
     *
     * @return FeaturedArticle[]
     */
    public function handle(): array
    {
        return $this->repository->findAll();
    }
}
