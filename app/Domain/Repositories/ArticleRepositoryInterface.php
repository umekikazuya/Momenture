<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Article;

interface ArticleRepositoryInterface
{
    /**
 * 指定された記事IDに対応する記事を取得する。
 *
 * 指定されたIDに該当する記事が存在する場合は Article オブジェクトを返し、存在しない場合は null を返します。
 *
 * @param int $id 取得対象の記事のID。
 * @return Article|null 対応する記事が存在する場合は Article オブジェクト、存在しない場合は null。
 */
    public function findById(int $id): ?Article;

    /**
 * キーワードに基づき記事を検索する。
 *
 * 指定されたキーワードに部分一致する記事を対象とし、オプションでサービスIDおよびタグIDによる絞り込みを行います。
 *
 * @param string $keyword 検索に使用するキーワード
 * @param int|null $serviceId オプション。記事が所属するサービスのID。指定された場合、そのサービスに絞り込みます
 * @param int|null $tagId オプション。記事に関連するタグのID。指定された場合、そのタグに紐づく記事に絞り込みます
 * @return Article[] 検索に一致した記事の配列
 */
    public function search(string $keyword, ?int $serviceId = null, ?int $tagId = null): array;

    /**
 * 指定されたフィルタ、ソート順、およびページネーション情報に基づいて記事の一覧を取得する。
 *
 * @param array  $filters  記事を絞り込むためのフィルタ条件の配列
 * @param string $sort     並び順を指定する文字列（例: 'asc' または 'desc'）
 * @param int    $page     取得するページ番号
 * @param int    $perPage  1ページあたりの記事の件数
 *
 * @return Article[]  条件に一致した記事の配列
 */
    public function findAll(array $filters, string $sort, int $page, int $perPage): array;

    /**
 * 指定された記事をリポジトリに保存する。
 *
 * このメソッドは、与えられた Article オブジェクトをデータベースやその他の永続化層に記録します。
 *
 * @param Article $article 保存対象の記事オブジェクト
 */
    public function save(Article $article): void;

    /**
 * 指定された記事を論理削除します。
 *
 * 論理削除により、記事データは保持されるものの、通常の検索結果から除外されます。
 *
 * @param Article $article 削除対象の記事インスタンス
 */
    public function delete(Article $article): void;

    /**
 * 指定された記事を完全に削除します。
 *
 * 論理削除ではなく、記事をデータベースから物理的に削除して、復元不可能な状態にします。
 *
 * @param Article $article 削除対象の記事
 */
    public function forceDelete(Article $article): void;

    /**
 * 論理削除された記事を復元する。
 *
 * 指定された記事の論理削除フラグを解除し、記事を再利用可能な状態に戻します。
 *
 * @param Article $article 復元対象の論理削除済み記事
 */
    public function restore(Article $article): void;

    /**
 * 指定された記事IDに対応する削除済みの記事を取得する。
 *
 * 該当する記事が存在しない場合は null を返す。
 *
 * @param int $id 削除済み記事の識別子
 * @return Article|null 取得された記事オブジェクト、または存在しない場合は null
 */
    public function findTrashedById(int $id): ?Article;
}
