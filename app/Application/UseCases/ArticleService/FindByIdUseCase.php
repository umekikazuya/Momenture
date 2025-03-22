<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Application\UseCases\ArticleService\FindByIdUseCaseInterface;
use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleServiceRepositoryInterface;
use App\Domain\ValueObjects\ArticleServiceId;

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
     * {@inheritDoc}
     */
    public function execute(ArticleServiceId $id): ArticleService
    {
        return $this->repository->findById($id->value());
    }
}
