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
     * 指定された記事IDに一致する記事エンティティを取得します。
     *
     * 与えられたIDを元にArticleModelを検索し、存在する場合はArticleエンティティに変換して返します。
     * 該当する記事が存在しない場合はnullを返却します。
     *
     * @param int $id 記事の識別子
     * @return Article|null 該当する記事エンティティ、または存在しない場合はnull
     */
    public function findById(int $id): ?Article
    {
        $model = ArticleModel::find($id);

        return $model ? $this->toEntity($model) : null;
    }

    /**
     * 指定されたIDに対応する削除済み（ソフトデリートされた）記事を取得します。
     *
     * このメソッドは、削除済みの記事も含めた検索を行い、見つかった場合は記事エンティティに変換して返します。
     * 該当の記事が存在しない場合は null を返します。
     *
     * @param int $id 検索対象の記事のID。
     * @return Article|null 指定されたIDの記事が存在する場合は Article エンティティ、存在しない場合は null。
     */
    public function findTrashedById(int $id): ?Article
    {
        $model = ArticleModel::withTrashed()->find($id);

        return $model ? $this->toEntity($model) : null;
    }

    /**
     * 指定されたフィルターとソート順に従い、ページネーション済みの記事一覧を取得する。
     *
     * フィルターに "status" が含まれる場合は、その状態で記事を絞り込みます。
     * ソートは、'created_at_desc' が指定された場合は作成日時の降順、それ以外の場合は昇順で行われます。
     * 取得した記事モデルは、Articleエンティティに変換されて返されます。
     *
     * @param array $filters  絞り込み条件。例: ['status' => 'active']。
     * @param string $sort    ソートオプション。'created_at_desc'の場合は降順、それ以外は昇順。
     * @param int $page       取得するページ番号。
     * @param int $perPage    1ページあたりの件数。
     *
     * @return array  Articleエンティティの配列。
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
     * 指定したキーワードとオプションのサービスIDおよびタグIDで記事を検索し、記事エンティティの配列を返します。
     *
     * キーワードが記事タイトルに部分一致する記事を検索し、サービスIDおよびタグIDが指定された場合はそれぞれの条件でフィルタリングを行います。
     *
     * @param string $keyword 検索するキーワード。
     * @param int|null $serviceId オプションのサービスIDによるフィルタリング条件。
     * @param int|null $tagId オプションのタグIDによるフィルタリング条件。
     *
     * @return array 検索結果のArticleエンティティの配列。
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
     * 指定された Article エンティティをデータベースに保存する。
     *
     * 新規エンティティの場合は ArticleModel のインスタンスを生成し、既存エンティティの場合は
     * ID に基づいてモデルを取得して更新します。指定された ID の記事が存在しない場合には
     * DomainException をスローします。
     *
     * @param Article $article 保存対象の Article エンティティ。
     *
     * @throws DomainException 指定された ID の記事が存在しない場合にスローされる。
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
     * 指定された記事に対応するモデルを削除する。
     *
     * 渡された Article オブジェクトの ID を用いて関連する ArticleModel を検索し、
     * モデルが存在する場合のみ削除処理を実行します。
     *
     * @param Article $article 削除対象の記事エンティティ
     */
    public function delete(Article $article): void
    {
        ArticleModel::find($article->id())?->delete();
    }

    /**
     * 指定された記事を完全に削除する。
     *
     * ソフトデリート状態の記事も含め、記事のIDに基づいて記事モデルを検索し、
     * 該当モデルが存在する場合は強制的に削除（ハードディリート）を実行します。
     *
     * @param Article $article 削除対象の記事エンティティ
     */
    public function forceDelete(Article $article): void
    {
        ArticleModel::withTrashed()->find($article->id())?->forceDelete();
    }

    /**
     * ソフトデリートされた記事を復元する。
     *
     * 指定された記事エンティティのIDに基づき、ソフトデリート済みの記事モデルを検索し、存在する場合はその復元を実行します。
     *
     * @param Article $article 復元対象の記事エンティティ
     */
    public function restore(Article $article): void
    {
        ArticleModel::withTrashed()->find($article->id())?->restore();
    }

    /**
     * 指定された ArticleModel インスタンスを Article エンティティに変換する
     *
     * ArticleModel の各プロパティを基に、Article エンティティを初期化します。記事の ID、タイトル、ステータス、サービス情報、リンク、作成・更新日時が変換されます。
     *
     * @param ArticleModel $model 変換する ArticleModel インスタンス
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
