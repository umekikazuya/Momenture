<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Article;
use App\Domain\Entities\ArticleService;
use App\Domain\Enums\ArticleStatus;
use App\Domain\Repositories\ArticleRepositoryInterface;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;
use App\Domain\ValueObjects\ArticleTitle;
use App\Models\Article as ArticleModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentArticleRepository implements ArticleRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function findById(int $id): Article
    {
        try {
            $model = ArticleModel::query()->findOrFail($id);

            return $this->toEntity($model);
        } catch (ModelNotFoundException $e) {
            throw new \DomainException("ID: {$id} の記事が見つかりません。");
        }
    }

    /**
     * {@inheritDoc}
     */
    public function findTrashedById(int $id): Article
    {
        try {
            $model = ArticleModel::query()->withTrashed()->findOrFail($id);

            return $this->toEntity($model);
        } catch (ModelNotFoundException $e) {
            throw new \DomainException("ID: {$id} の記事が見つかりません。");
        }
    }

    /**
     * {@inheritDoc}
     */
    public function findAll(array $filters, string $sort, int $page, int $perPage): array
    {
        $query = ArticleModel::query();

        if (isset($filters['service_id'])) {
            $query->where('article_service_id', $filters['service_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $query->orderBy('created_at', $sort === 'created_at_desc' ? 'desc' : 'asc');
        // $query->paginate($perPage ?: null, ['*'], 'page', null);

        return $query->get()
            ->map(fn ($model) => $this->toEntity($model))
            ->all();
    }

    /**
     * {@inheritDoc}
     */
    public function search(?string $keyword, ?int $serviceId = null, ?int $tagId = null): array
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

    /**
     * {@inheritDoc}
     */
    public function create(Article $article): Article
    {
        try {
            $model = ArticleModel::query()->create(
                [
                'title' => $article->title()->value(),
                'status' => $article->isPublished()
                    ? ArticleStatus::PUBLISHED->value
                    : ArticleStatus::DRAFT->value,
                'article_service_id' => $article->service()->id()->value(),
                'link' => $article->hasLink()
                    ? $article->link()->value()
                        : null,
                ]
            );
            $model->setCreatedAt($article->createdAt());
            $model->setUpdatedAt($article->updatedAt());
            $model->save();

            return $this->toEntity($model);
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function update(Article $article): Article
    {
        try {
            $model = ArticleModel::query()->findOrFail($article->id());
            $model->title = $article->title()->value();
            $model->status = $article->isPublished()
                ? ArticleStatus::PUBLISHED->value
                : ArticleStatus::DRAFT->value;
            $model->article_service_id = $article->service()->id()->value();
            $model->link = $article->hasLink()
                ? $article->link()->value()
                : null;
            $model->setCreatedAt($article->createdAt());
            $model->setUpdatedAt($article->updatedAt());
            $model->save();

            return $this->toEntity($model);
        } catch (\DomainException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): void
    {
        try {
            // 既に削除済みの場合は例外をスローする
            $model = ArticleModel::query()->findOrFail($id);
            $model->delete();
        } catch (ModelNotFoundException $e) {
            throw new \DomainException("ID: {$id} の記事が見つかりません。");
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function forceDelete(int $id): void
    {
        try {
            // 記事の存在チェック
            $model = ArticleModel::query()->withTrashed()->findOrFail($id);
            $model->forceDelete();
        } catch (ModelNotFoundException $e) {
            throw new \DomainException("ID: {$id} の記事が見つかりません。");
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function restore(Article $article): void
    {
        try {
            ArticleModel::withTrashed()->findOrFail($article->id())->restore();
        } catch (ModelNotFoundException $e) {
            throw new \DomainException("ID: {$article->id()} の記事が見つかりません。");
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * ArticleModelのデータをArticleエンティティに変換する。
     *
     * Eloquentモデルの各プロパティを対応する値オブジェクトに変換し、新たなArticleエンティティを生成します。
     *
     * @param  ArticleModel $model 変換対象のEloquent記事モデル
     * @return Article 変換されたArticleエンティティ
     */
    private function toEntity(ArticleModel $model): Article
    {
        return new Article(
            id: $model->id,
            title: new ArticleTitle($model->title),
            status: ArticleStatus::from($model->status),
            service: new ArticleService(
                new ArticleServiceId($model->article_service_id),
                new ArticleServiceName($model->articleService?->name ?? '')
            ),
            link: $model->link ? new ArticleLink($model->link) : null,
            createdAt: \DateTimeImmutable::createFromMutable($model->created_at),
            updatedAt: \DateTimeImmutable::createFromMutable($model->updated_at),
        );
    }
}
