<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleServiceRepositoryInterface;
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

    public function create(ArticleService $article): ArticleService
    {
        $model = ArticleServiceModel::create(['name' => $article->name()->value()]);

        return $this->toEntity($model);
    }

    public function update(ArticleService $article): ArticleService
    {
        $model = ArticleServiceModel::find($article->id());
        $model->name = $article->name();
        $model->save();

        return $this->toEntity($model);
    }

    public function delete(ArticleService $article): void
    {
        ArticleServiceModel::destroy($article->id()->value());
    }

    public function forceDelete(ArticleService $article): void
    {
        ArticleServiceModel::withTrashed()->find($article->id()->value())->forceDelete();
    }

    private function toEntity(ArticleServiceModel $model): ArticleService
    {
        return new ArticleService(
            $model->id,
            $model->name
        );
    }
}
