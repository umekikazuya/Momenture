<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\FeaturedArticle;
use App\Domain\Repositories\ArticleRepositoryInterface;
use App\Domain\Repositories\FeaturedArticleRepositoryInterface;
use App\Domain\ValueObjects\FeaturedArticleId;
use App\Domain\ValueObjects\FeaturedPriority;
use App\Models\FeaturedArticle as FeaturedArticleModel;

class EloquentFeaturedArticleRepository implements FeaturedArticleRepositoryInterface
{
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository
    )
    {
    }

    public function findAll(): array
    {
        return FeaturedArticleModel::where('is_active', true)
            ->orderBy('priority')
            ->get()
            ->map(fn ($model) => $this->toEntity($model))
            ->toArray();
    }

    public function add(int $articleId, FeaturedPriority $priority): void
    {
        FeaturedArticleModel::create([
            'article_id' => $articleId,
            'priority' => $priority->value(),
            'is_active' => true,
        ]);
    }

    public function updatePriority(FeaturedArticleId $id, FeaturedPriority $priority): void
    {
        FeaturedArticleModel::where('id', $id->value())
            ->update(['priority' => $priority->value()]);
    }

    public function deactivate(FeaturedArticleId $id): void
    {
        FeaturedArticleModel::where('id', $id->value())
            ->update(['is_active' => false]);
    }

    public function findById(FeaturedArticleId $id): ?FeaturedArticle
    {
        $model = FeaturedArticleModel::find($id->value());

        return $model ? $this->toEntity($model) : null;
    }

    public function countActive(): int
    {
        return FeaturedArticleModel::where('is_active', true)->count();
    }

    private function toEntity(FeaturedArticleModel $model): FeaturedArticle
    {
        $article = $this->articleRepository->findById($model->article_id);
        return new FeaturedArticle(
            new FeaturedArticleId($model->id),
            $article,
            new FeaturedPriority($model->priority),
            $model->is_active,
            new \DateTimeImmutable($model->created_at)
        );
    }
}
