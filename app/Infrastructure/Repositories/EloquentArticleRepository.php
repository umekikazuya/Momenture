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
    /**
     * 指定したIDに基づいて記事を検索し、Articleエンティティに変換して返す。
     *
     * ArticleModelから指定されたIDの記事を検索し、存在する場合はArticleエンティティに変換して返します。
     * 記事が見つからない場合はnullを返します。
     *
     * @param int $id 検索対象の記事のID
     * @return Article|null 変換済みのArticleエンティティ、または記事が存在しない場合はnull
     */
    public function findById(int $id): ?Article
    {
        $model = ArticleModel::find($id);

        return $model ? $this->toEntity($model) : null;
    }

    /**
     * 指定された ID に基づき、削除済みを含む記事を取得する。
     *
     * 指定された記事が存在すれば Article エンティティに変換して返し、見つからなければ null を返します。
     *
     * @param int $id 記事の識別子
     * @return Article|null 取得された記事のエンティティ、存在しない場合は null
     */
    public function findTrashedById(int $id): ?Article
    {
        $model = ArticleModel::withTrashed()->find($id);

        return $model ? $this->toEntity($model) : null;
    }

    /**
     * 指定されたフィルター、ソート順、ページ情報に基づいて記事を取得し、Articleエンティティの配列として返す。
     *
     * フィルター配列に 'status' が含まれる場合、その値で記事が絞り込まれます。ソート順が 'created_at_desc' の場合は降順、それ以外の場合は昇順で 'created_at' 順に並び替え、指定されたページ番号と件数でページネーションされた結果を返します。
     *
     * @param array $filters 例: ['status' => 'published'] のような、記事のフィルタリング条件。
     * @param string $sort 'created_at_desc' で降順、それ以外は昇順で記事を並べ替え。
     * @param int $page 取得するページ番号。
     * @param int $perPage 1ページあたりの件数。
     * @return array Articleエンティティの配列。
     */
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

    /**
     * 与えられたキーワード、サービスID、タグIDに基づいて記事を検索し、Articleエンティティの配列を返す。
     *
     * キーワードが指定されると、記事タイトルに部分一致する記事が検索されます。
     * サービスIDやタグIDが指定された場合、それぞれの条件に一致する記事に絞り込みを行います。
     * 検索結果はデータモデルからArticleエンティティに変換して返されます。
     *
     * @param string $keyword 検索に使用するキーワード（タイトルの部分一致検索）。
     * @param int|null $serviceId オプション。記事のサービスIDでフィルタリングする場合に指定。
     * @param int|null $tagId オプション。記事に関連付けられたタグのIDでフィルタリングする場合に指定。
     *
     * @return array 該当するArticleエンティティの配列。
     */
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

    /**
     * 指定された Article エンティティをデータベースに保存します。
     *
     * Article の ID が設定されている場合は対応する記事を検索して更新し、存在しない場合は DomainException をスローします。
     * ID が設定されていない場合は新規記事として作成します。
     *
     * @param Article $article 保存対象の Article エンティティ
     *
     * @throws \DomainException 指定された ID の記事が存在しない場合
     */
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

    /**
     * 渡された記事エンティティのIDに基づき、対応する記事モデルを削除します。
     *
     * 対象記事が存在する場合はモデルを取得し削除（ソフトデリート）を実行します。
     * 該当記事が見つからなかった場合は、何も処理されません。
     *
     * @param Article $article 削除対象の記事エンティティ。
     */
    public function delete(Article $article): void
    {
        ArticleModel::find($article->id())?->delete();
    }

    /**
     * 指定された記事をデータベースから完全に削除する。
     *
     * 指定された記事エンティティのIDに基づいて、論理削除済みを含む記事モデルを検索し、
     * 存在する場合は強制的に削除します。対象の記事が存在しない場合は何も行いません。
     *
     * @param Article $article 完全削除対象の記事エンティティ
     */
    public function forceDelete(Article $article): void
    {
        ArticleModel::withTrashed()->find($article->id())?->forceDelete();
    }

    /**
     * 論理削除された記事を復元します。
     *
     * 指定された記事エンティティのIDを用いて、削除済みも含む全レコードから対象の記事を検索し、
     * 見つかった場合にその記事の削除状態を解除します。
     *
     * @param Article $article 復元対象の記事エンティティ。
     */
    public function restore(Article $article): void
    {
        ArticleModel::withTrashed()->find($article->id())?->restore();
    }

    /**
     * ArticleModel から Article エンティティへ変換します。
     *
     * 指定された ArticleModel のプロパティを用いて、新しい Article エンティティを生成します。
     * これには記事のID、タイトル、状態、サービス情報、リンク、および作成・更新日時が含まれます。
     *
     * @param ArticleModel $model 変換元の記事モデル。
     * @return Article 生成された Article エンティティ。
     */
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
