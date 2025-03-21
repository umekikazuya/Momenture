<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Application\UseCases\ArticleService\FindByIdUseCaseInterface;
use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleServiceRepositoryInterface;

class FindByIdUseCase implements FindByIdUseCaseInterface
{
    /**
     * コンストラクタ。
     *
     * 依存性注入された ArticleServiceRepositoryInterface を設定し、記事サービスの検索に必要なリポジトリを初期化します。
     */
    public function __construct(private ArticleServiceRepositoryInterface $repository)
    {
    }

    /**
     * 指定されたIDを元に記事サービスを取得する。
     *
     * リポジトリを用いて、指定されたIDに一致するArticleServiceインスタンスを検索し、
     * 存在する場合はそのインスタンスを、見つからない場合はnullを返します。
     *
     * @param int $id 検索対象の記事サービスのID
     *
     * @return ArticleService|null 該当する記事サービスが存在する場合はそのインスタンス、存在しない場合はnull
     */
    public function execute(int $id): ?ArticleService
    {
        return $this->repository->findById($id);
    }
}
