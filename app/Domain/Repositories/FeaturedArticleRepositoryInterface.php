<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\FeaturedArticle;
use App\Domain\ValueObjects\FeaturedArticleId;
use App\Domain\ValueObjects\FeaturedPriority;

interface FeaturedArticleRepositoryInterface
{
    /**
     * 注目記事一覧を取得（優先度順）
     *
     * @return FeaturedArticle[]
     */
    public function findAll(): array;

    /**
     * 新しい注目記事を追加する。
     *
     * 指定された記事IDと優先度を使用して、記事を注目記事リストに追加します。
     *
     * @param int              $articleId 追加する記事の識別子
     * @param FeaturedPriority $priority  記事の表示優先度を表すオブジェクト
     *
     * @throws \RuntimeException データベースエラーが発生した場合
     */
    public function add(int $articleId, FeaturedPriority $priority): void;

    /**
     * 指定された注目記事の優先度を更新する。
     *
     * 更新対象の注目記事を識別するIDと新しい優先度を受け取り、記事の表示順序を更新します。
     *
     * @param FeaturedArticleId $id       更新対象の注目記事を示す識別子。
     * @param FeaturedPriority  $priority 設定する新しい優先度を表す値オブジェクト。
     *
     * @throws \DomainException 指定されたIDで該当するレコードが見つからなかった場合にスローされる。
     */
    public function updatePriority(FeaturedArticleId $id, FeaturedPriority $priority): void;

    /**
     * 指定された注目記事の状態を無効化します。
     *
     * このメソッドは、対象の注目記事の is_active プロパティを false に設定し、記事を無効な状態に更新します。
     *
     * @param FeaturedArticleId $id 無効化する注目記事の識別子
     *
     * @throws \DomainException 指定されたIDで該当するレコードが見つからなかった場合にスローされる。
     */
    public function deactivate(FeaturedArticleId $id): void;

    /**
     * 指定された識別子に対応する注目記事を取得する。
     *
     * 指定した FeaturedArticleId を元に注目記事を検索し、存在する場合はそのオブジェクトを返します。
     * 見つからない場合は null を返します。
     *
     * @param  FeaturedArticleId $id 対象の注目記事の識別子
     * @return FeaturedArticle|null 該当する注目記事、存在しない場合は null
     */
    public function findById(FeaturedArticleId $id): ?FeaturedArticle;

    /**
     * 有効なフィーチャード記事の件数を取得します。
     *
     * このメソッドは、アクティブなフィーチャード記事の数を返し、登録数の上限チェックなどに利用されます。
     *
     * @return int 有効なフィーチャード記事の件数
     */
    public function countActive(): int;
}
