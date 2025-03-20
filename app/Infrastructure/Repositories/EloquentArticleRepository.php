<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Article;
use App\Domain\Entities\ArticleService;
use App\Domain\Enums\ArticleStatus;
use App\Domain\Repositories\ArticleRepositoryInterface;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleTitle;
use App\Models\Article as ArticleModel;

class EloquentArticleRepository implements ArticleRepositoryInterface
{
    public function findById(int $id): ?Article
    {
        $model = ArticleModel::find($id);

        return $model ? $this->toEntity($model) : null;
    }

    public function findTrashedById(int $id): ?Article
    {
        $model = ArticleModel::withTrashed()->find($id);

        return $model ? $this->toEntity($model) : null;
    }

    public function findAll(array $filters, string $sort, int $page, int $perPage): array
    {
        $query = ArticleModel::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $query->orderBy('created_at', $sort === 'created_at_desc' ? 'desc' : 'asc');

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        return collect($paginator->items())
            ->map(fn ($model) => $this->toEntity($model))
            ->all();
    }

    public function search(string $keyword, ?int $serviceId = null, ?int $tagId = null): array
    {
        $query = ArticleModel::query();

        if ($keyword) {
            $query->where('title', 'LIKE', "%{$keyword}%");
        }

        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }

        if ($tagId) {
            $query->whereHas('tags', fn ($q) => $q->where('tags.id', $tagId));
        }

        return $query->get()->map(fn ($model) => $this->toEntity($model))->all();
    }

    public function save(Article $article): void
    {
        /** @var ArticleModel $model */
        $model = $article->id() ? ArticleModel::find($article->id()) : new ArticleModel();
        if ($article->id() && !$model) {
            throw new \DomainException('該当IDの記事が見つかりません。');
        }
        $model->title = $article->title()->value();
        $model->status = $article->isPublished() ? ArticleStatus::PUBLISHED->value : ArticleStatus::DRAFT->value;
        $model->article_service_id = $article->service()->id();
        $model->link = $article->hasLink() ? $article->link()->value() : null;
        $model->save();
    }

    public function delete(Article $article): void
    {
        ArticleModel::find($article->id())?->delete();
    }

    public function forceDelete(Article $article): void
    {
        ArticleModel::withTrashed()->find($article->id())?->forceDelete();
    }

    public function restore(Article $article): void
    {
        ArticleModel::withTrashed()->find($article->id())?->restore();
    }

    private function toEntity(ArticleModel $model): Article
    {
        return new Article(
            id: $model->id,
            title: new ArticleTitle($model->title),
            status: ArticleStatus::from($model->status),
            service: new ArticleService($model->article_service_id, $model->articleService?->name ?? ''),
            link: $model->link ? new ArticleLink($model->link) : null,
            createdAt: \DateTimeImmutable::createFromMutable($model->created_at),
            updatedAt: \DateTimeImmutable::createFromMutable($model->updated_at),
        );
    }
}
