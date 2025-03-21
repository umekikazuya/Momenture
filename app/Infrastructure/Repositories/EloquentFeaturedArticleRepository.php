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
    public function __construct(protected ArticleRepositoryInterface $articleRepository) {}

    public function findAll(): array
    {
        return FeaturedArticleModel::query()
            ->where('is_active', true)
            ->orderBy('priority')
            ->get()
            ->map(fn ($model) => $this->toEntity($model))
            ->toArray();
    }

    public function add(int $articleId, FeaturedPriority $priority): void
    {
        FeaturedArticleModel::query()
            ->create([
                'article_id' => $articleId,
                'priority' => $priority->value(),
                'is_active' => true,
            ]);
    }

    public function updatePriority(FeaturedArticleId $id, FeaturedPriority $priority): void
    {
        $rows = FeaturedArticleModel::query()
            ->where('id', $id->value())
            ->update(['priority' => $priority->value()]);

        if ($rows === 0) {
            throw new \RuntimeException(
                '指定されたIDで更新対象のレコードが見つかりません: '.$id->value()
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function deactivate(FeaturedArticleId $id): void
    {
        $rows = FeaturedArticleModel::query()
            ->where('id', $id->value())
            ->update(['is_active' => false]);
        if ($rows === 0) {
            throw new \RuntimeException(
                '指定されたIDで削除対象のレコードが見つかりません: '.$id->value()
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function findById(FeaturedArticleId $id): ?FeaturedArticle
    {
        $model = FeaturedArticleModel::find($id->value());

        return $model ? $this->toEntity($model) : null;
    }

    /**
     * {@inheritDoc}
     */
    public function countActive(): int
    {
        return FeaturedArticleModel::where('is_active', true)->count();
    }

    /**
     * モデルからエンティティに変換
     */
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
