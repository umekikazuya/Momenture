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
    public function __construct(private ArticleServiceRepositoryInterface $articleServiceRepository)
    {
    }

    /**
     * 指定されたArticleServiceオブジェクトをリポジトリ上で更新し、更新済みのオブジェクトを返却します。
     *
     * 内部のリポジトリを介してArticleServiceの状態を永続化します。
     *
     * @param ArticleService $articleService 更新対象のArticleServiceオブジェクト
     * @return ArticleService 更新後のArticleServiceオブジェクト
     */
    public function execute(
        ArticleService $articleService,
    ): ArticleService {
        $this->articleServiceRepository->update($articleService);

        return $articleService;
    }
}
