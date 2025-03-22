<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleServiceRepositoryInterface;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;
use App\Models\ArticleService as ArticleServiceModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentArticleServiceRepository implements ArticleServiceRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function findById(int $id): ArticleService
    {
        try {
            $model = ArticleServiceModel::query()->findOrFail($id);

            return $this->toEntity(model: $model);
        } catch (ModelNotFoundException $e) {
            throw new \DomainException("ID: {$id} の記事サービスが見つかりません。");
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function findAll(): array
    {
        $models = ArticleServiceModel::all();
        $entities = [];
        foreach ($models as $model) {
            $entities[] = $this->toEntity(model: $model);
        }

        return $entities;
    }

    /**
     * {@inheritDoc}
     */
    public function create(ArticleService $entity): ArticleService
    {
        try {
            $model = ArticleServiceModel::query()
                ->create(['name' => $entity->name()->value()]);

            return $this->toEntity(model: $model);
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function update(ArticleService $entity): ArticleService
    {
        try {
            $model = ArticleServiceModel::query()->findOrFail($entity->id()->value());
            $model->name = $entity->name()->value();
            $model->save();
            return $this->toEntity(model: $model);
        } catch (\DomainException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function delete(ArticleService $entity): void
    {
        try {
            ArticleServiceModel::destroy($entity->id()->value());
        } catch (\Exception $e) {
            throw new \RuntimeException('削除処理中にエラーが発生しました。');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function forceDelete(ArticleService $entity): void
    {
        try {
            ArticleServiceModel::query()->withTrashed()->forceDelete($entity->id()->value());
        } catch (\Exception $e) {
            throw new \RuntimeException('削除処理中にエラーが発生しました。');
        }
    }

    /**
     * {@inheritDoc}
     */
    private function toEntity(ArticleServiceModel $model): ArticleService
    {
        return new ArticleService(
            new ArticleServiceId($model->id),
            new ArticleServiceName($model->name)
        );
    }
}
