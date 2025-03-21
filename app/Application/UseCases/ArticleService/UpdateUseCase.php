<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleServiceRepositoryInterface;

class UpdateUseCase implements UpdateUseCaseInterface
{
    /**
     * UpdateUseCase クラスのコンストラクタ。
     *
     * ArticleServiceRepositoryInterface のインスタンスを受け取り、記事サービスの更新処理に必要なリポジトリを初期化します。
     */
    public function __construct(private ArticleServiceRepositoryInterface $articleServiceRepository) {
    }

    /**
     * {@inheritDoc}
     */
    public function execute(
        ArticleService $articleService,
    ): ArticleService {
        try {
            $this->articleServiceRepository->update($articleService);

            return $articleService;
        } catch (\DomainException $e) {
            throw $e;
        }
    }
}
