<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleServiceRepositoryInterface;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;

class UpdateUseCase implements UpdateUseCaseInterface
{
    /**
     * UpdateUseCase クラスのコンストラクタ。
     *
     * ArticleServiceRepositoryInterface のインスタンスを受け取り、記事サービスの更新処理に必要なリポジトリを初期化。
     */
    public function __construct(private ArticleServiceRepositoryInterface $articleServiceRepository)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function execute(
        ArticleServiceId $id,
        ArticleServiceName $name,
    ): ArticleService {
        try {
            $entity = $this->articleServiceRepository->findById($id->value());
            // エンティティの更新.
            $entity->updateName($name);
            // モデルの更新.
            $this->articleServiceRepository->update($entity);
            return $entity;
        } catch (\DomainException $e) {
            throw $e;
        } catch (\RuntimeException $e) {
            throw $e;
        }
    }
}
