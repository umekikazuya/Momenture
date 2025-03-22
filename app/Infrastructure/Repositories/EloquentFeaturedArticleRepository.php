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
    /**
     * コンストラクタ
     *
     * 記事リポジトリの依存性注入により、記事データ管理に必要なリポジトリインスタンスを保持します。
     *
     * @param ArticleRepositoryInterface $articleRepository 記事リポジトリのインスタンス
     */
    public function __construct(protected ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function findAll(): array
    {
        try {
            $models = FeaturedArticleModel::query()
                ->where('is_active', true)
                ->orderBy('priority')
                ->get();

            return $models
                ->filter(
                    function ($model) {
                        try {
                            return $model->toEntity($model);
                        } catch (\Exception $e) {
                            return null;
                        }
                    }
                )
                ->map(
                    fn ($model) => $this->toEntity($model)
                )
                ->toArray();
        } catch (\Exception $e) {
            throw new \RuntimeException(
                '注目記事の取得に失敗しました。',
                0,
                $e
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function add(int $articleId, FeaturedPriority $priority): void
    {
        try {
            FeaturedArticleModel::query()->create(
                [
                    'article_id' => $articleId,
                    'priority' => $priority->value(),
                    'is_active' => true,
                ]
            );
        } catch (\Exception $e) {
            throw new \RuntimeException(
                "注目記事の追加に失敗しました。記事ID: {$articleId}",
                0,
                $e
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function updatePriority(FeaturedArticleId $id, FeaturedPriority $priority): void
    {
        $rows = FeaturedArticleModel::query()
            ->where('id', $id->value())
            ->update(['priority' => $priority->value()]);

        if ($rows === 0) {
            throw new \DomainException(
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
            throw new \DomainException(
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
     * アクティブな注目記事の件数を取得します。
     *
     * データベースから「is_active」が true の注目記事レコードをカウントし、その件数を返します。
     *
     * @return int アクティブな注目記事の総件数。
     */
    public function countActive(): int
    {
        return FeaturedArticleModel::where('is_active', true)->count();
    }

    /**
     * 指定されたFeaturedArticleModelから対応するFeaturedArticleエンティティを生成する。
     *
     * モデルに含まれるID、優先度、状態、作成日時の情報を基に、articleRepositoryから関連する記事情報を取得した上で
     * 新たなFeaturedArticleエンティティを構築して返します。
     *
     * @param  FeaturedArticleModel $model 変換対象のモデルインスタンス
     * @return FeaturedArticle 生成されたエンティティ
     *
     * @throws \RuntimeException 記事情報の取得に失敗した場合
     */
    private function toEntity(FeaturedArticleModel $model): FeaturedArticle
    {
        $article = $this->articleRepository->findById($model->article_id);
        if ($article === null) {
            throw new \RuntimeException(
                '記事情報の取得に失敗しました。記事ID: '. $model->article_id
            );
        }

        return new FeaturedArticle(
            new FeaturedArticleId($model->id),
            $article,
            new FeaturedPriority($model->priority),
            $model->is_active,
            new \DateTimeImmutable($model->created_at)
        );
    }
}
