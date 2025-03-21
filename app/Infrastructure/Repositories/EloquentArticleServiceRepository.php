<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleServiceRepositoryInterface;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;
use App\Models\ArticleService as ArticleServiceModel;

class EloquentArticleServiceRepository implements ArticleServiceRepositoryInterface
{
    public function findById(int $id): ?ArticleService
    {
        $model = ArticleServiceModel::find($id);

        return $model ? $this->toEntity($model) : null;
    }

    public function findAll(): array
    {
        $models = ArticleServiceModel::all();
        $entities = [];
        foreach ($models as $model) {
            $entities[] = $this->toEntity($model);
        }

        return $entities;
    }

    public function create(ArticleService $articleService): ArticleService
    {
        $model = ArticleServiceModel::create(['name' => $articleService->name()->value()]);

        return $this->toEntity($model);
    }

    public function update(ArticleService $articleService): ArticleService
    {
        $model = ArticleServiceModel::find($articleService->id()->value());

        if (! $model) {
            throw new \DomainException("ID: {$articleService->id()->value()} の記事サービスが見つかりません。");
        }

        $model->name = $articleService->name()->value();
        $model->save();

        return $this->toEntity($model);
    }

    public function delete(ArticleService $articleService): void
    {
        ArticleServiceModel::destroy($articleService->id()->value());
    }

    public function forceDelete(ArticleService $articleService): void
    {
        $model = ArticleServiceModel::withTrashed()->find($articleService->id()->value());

        if (! $model) {
            throw new \DomainException("ID: {$articleService->id()->value()} の記事サービスが見つかりません。");
        }
        $model->forceDelete();
    }

    private function toEntity(ArticleServiceModel $model): ArticleService
    {
        return new ArticleService(
            new ArticleServiceId($model->id),
            new ArticleServiceName($model->name)
        );
    }
}
