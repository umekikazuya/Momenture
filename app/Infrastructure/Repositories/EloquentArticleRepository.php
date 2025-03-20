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
     * 指定されたIDの記事を取得する。
     *
     * 与えられたIDでArticleModelを検索し、記事が存在する場合はそれをArticleエンティティに変換して返します。
     * 記事が見つからない場合はnullを返します。
     *
     * @param int $id 検索する記事の一意な識別子
     * @return Article|null 記事が存在する場合はArticleエンティティ、存在しない場合はnull
     */
    public function findById(int $id): ?Article
    {
        $model = ArticleModel::find($id);

        return $model ? $this->toEntity($model) : null;
    }

    /**
     * 指定されたIDの、削除済み状態も含む記事を取得し、Articleエンティティに変換して返します。
     *
     * ソフトデリートされた記事も対象とするため、通常の検索では取得できない記事が存在する場合にも対応します。
     * 記事が存在すればArticleエンティティに変換して返し、存在しない場合はnullを返します。
     *
     * @param int $id 記事の一意の識別子
     * @return Article|null 見つかった記事のArticleエンティティ、記事が存在しない場合はnull
     */
    public function findTrashedById(int $id): ?Article
    {
        $model = ArticleModel::withTrashed()->find($id);

        return $model ? $this->toEntity($model) : null;
    }

    /**
     * 指定されたフィルタ、ソート順、ページ番号、1ページあたりの件数に基づいて記事エンティティの配列を取得します。
     *
     * フィルタに 'status' キーが含まれている場合、その状態のみに絞り込みを行います。また、$sort が 'created_at_desc' の場合は作成日時の降順、それ以外の場合は昇順でソートされます。
     *
     * @param array $filters 記事抽出の条件。例：'status' => 記事の状態
     * @param string $sort ソート基準。'created_at_desc' を指定すると作成日時の降順となります。
     * @param int $page 現在のページ番号
     * @param int $perPage 1ページあたりの項目数
     *
     * @return array 指定された条件に合致する記事エンティティの配列
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
     * キーワードおよびオプションのサービスIDとタグIDで記事を検索し、Articleエンティティの配列を返す。
     *
     * タイトルの部分一致検索を行い、指定されたサービスIDやタグIDがある場合はそれらを条件に加えてフィルタリングします。  
     * 条件に一致する記事モデルを取得し、Articleエンティティへ変換して返します。
     *
     * @param string $keyword 検索に用いるキーワード（タイトルの部分一致検索に利用）。
     * @param int|null $serviceId （オプション）記事が属するサービスのID。指定された場合、そのサービスに関連する記事のみ対象となる。
     * @param int|null $tagId （オプション）記事に結び付けられたタグのID。指定された場合、そのタグに関連付けられた記事のみ対象となる。
     *
     * @return Article[] 条件に合致したArticleエンティティの配列。
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
     * 指定された記事エンティティをデータベースに保存する。
     *
     * 記事エンティティにIDが含まれている場合は、既存の記事の更新を行い、該当記事が存在しない場合はDomainExceptionをスローします。
     * IDが設定されていない場合は、新規記事として作成して保存します。
     *
     * @param Article $article 保存する記事エンティティ
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
     * 指定された記事エンティティに対応するレコードを削除する。
     *
     * 記事エンティティのIDを用いてデータベース内のレコードを検索し、存在する場合は削除処理を実行する。
     *
     * @param Article $article 削除対象の記事エンティティ
     */
    public function delete(Article $article): void
    {
        ArticleModel::find($article->id())?->delete();
    }

    /**
     * 指定された記事をデータベースから恒久的に削除します。
     *
     * 記事がソフトデリート状態であっても、モデルを検索して完全に削除します。記事が存在しない場合は何も行いません。
     *
     * @param Article $article 削除対象の記事エンティティ
     */
    public function forceDelete(Article $article): void
    {
        ArticleModel::withTrashed()->find($article->id())?->forceDelete();
    }

    /**
     * 指定された記事のソフトデリートを解除して復元します。
     *
     * このメソッドは、記事IDに対応するソフトデリートされた記事モデルを検索し、存在する場合に復元を実施します。
     * 該当する記事モデルが見つからない場合は、何も行いません。
     *
     * @param Article $article 復元対象の記事エンティティ
     */
    public function restore(Article $article): void
    {
        ArticleModel::withTrashed()->find($article->id())?->restore();
    }

    /**
     * ArticleModel インスタンスを Article エンティティに変換する。
     *
     * 記事モデルの各プロパティを使用して、新しい Article エンティティを生成します。
     *
     * @param ArticleModel $model 変換対象のモデル
     * @return Article 変換された Article エンティティ
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
