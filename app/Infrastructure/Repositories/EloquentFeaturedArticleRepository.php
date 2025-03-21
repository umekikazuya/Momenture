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
 */
public function __construct(protected ArticleRepositoryInterface $articleRepository) {}

    /**
     * 有効なフィーチャー記事を全件取得し、優先度順に並べ替えてエンティティ化した配列を返します。
     *
     * データベースから is_active が true のフィーチャー記事を取得し、優先度に従って並べ替えた後、各モデルをドメインエンティティに変換します。
     *
     * @return FeaturedArticle[] 有効なフィーチャー記事のエンティティ配列
     */
    public function findAll(): array
    {
        return FeaturedArticleModel::query()
            ->where('is_active', true)
            ->orderBy('priority')
            ->get()
            ->map(fn ($model) => $this->toEntity($model))
            ->toArray();
    }

    /**
     * 指定された記事IDと優先度に基づいて、新しいフィーチャー記事レコードを作成する。
     *
     * このメソッドは、提供された記事の識別子とフィーチャー記事の優先度に応じて、
     * データベースにアクティブなフィーチャー記事レコードを追加します。
     *
     * @param int $articleId 追加する記事の識別子。
     * @param FeaturedPriority $priority フィーチャー記事の優先度を示すオブジェクト。
     */
    public function add(int $articleId, FeaturedPriority $priority): void
    {
        FeaturedArticleModel::query()
            ->create([
                'article_id' => $articleId,
                'priority' => $priority->value(),
                'is_active' => true,
            ]);
    }

    /**
     * 指定されたフィーチャード記事の識別子に基づいて、優先度を更新する。
     *
     * 対象のレコードが見つからない場合には、RuntimeException をスローする。
     *
     * @param FeaturedArticleId $id 更新対象のフィーチャード記事の識別子。
     * @param FeaturedPriority  $priority 新しく設定する優先度。
     *
     * @throws \RuntimeException 指定されたIDで該当するレコードが見つからなかった場合にスローされる。
     */
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
     * 指定された特集記事のIDに基づいて、その記事を非アクティブ状態に更新します。
     *
     * レコードが存在しない場合は、指定されたIDに該当するレコードが更新されなかった旨のRuntimeExceptionをスローします。
     *
     * @param FeaturedArticleId $id 特集記事の識別子
     *
     * @throws \RuntimeException 指定されたIDのレコードが存在しない場合
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
     * 指定されたIDに対応する注目記事エンティティを取得します。
     *
     * 指定されたFeaturedArticleIdを用いてデータベースから注目記事のレコードを検索し、
     * 該当レコードが存在する場合は該当モデルをFeaturedArticleエンティティに変換して返します。
     * レコードが存在しない場合はnullを返します。
     *
     * @param FeaturedArticleId $id 検索対象の注目記事の識別子
     *
     * @return FeaturedArticle|null 指定IDに対応する注目記事エンティティ、存在しない場合はnull
     */
    public function findById(FeaturedArticleId $id): ?FeaturedArticle
    {
        $model = FeaturedArticleModel::find($id->value());

        return $model ? $this->toEntity($model) : null;
    }

    /**
     * アクティブなフィーチャー記事の件数を取得します。
     *
     * データベースから「is_active」が true のフィーチャー記事レコードをカウントし、その件数を返します。
     *
     * @return int アクティブなフィーチャー記事の総件数。
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
     * @param FeaturedArticleModel $model 変換対象のモデルインスタンス
     * @return FeaturedArticle 生成されたエンティティ
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
