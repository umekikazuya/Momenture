<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleServiceRepositoryInterface;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;

class CreateUseCase implements CreateUseCaseInterface
{
    /**
     * CreateUseCaseクラスの新しいインスタンスを初期化する。
     *
     * 指定された記事サービスリポジトリを内部プロパティに設定し、記事サービスの作成および永続化に必要な依存関係を注入します。
     */
    public function __construct(
        private ArticleServiceRepositoryInterface $repository
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function execute(string $name): ArticleService
    {
        $article = new ArticleService(
            id: new ArticleServiceId(0),
            name: new ArticleServiceName($name),
        );
        try {
            $this->repository->create($article);
            return $article;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
