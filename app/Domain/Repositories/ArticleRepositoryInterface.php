<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Article;

interface ArticleRepositoryInterface
{
    /**
 * 指定された記事IDに対応する記事を返します。該当する記事が存在しない場合は null を返します。
 *
 * @param int $id 記事の一意な識別子
 *
 * @return Article|null 該当する記事が存在すれば Article オブジェクト、なければ null
 */
    public function findById(int $id): ?Article;

    /**
 * キーワードに基づいて記事を検索する。
 *
 * 指定したキーワードに一致する記事を、任意でサービスIDおよびタグIDによるフィルタを適用し検索します。
 *
 * @param string $keyword 検索対象のキーワード
 * @param int|null $serviceId オプションのサービスIDフィルタ。指定しない場合はnull。
 * @param int|null $tagId オプションのタグIDフィルタ。指定しない場合はnull。
 *
 * @return Article[] 検索条件に一致する記事の配列
 */
    public function search(string $keyword, ?int $serviceId = null, ?int $tagId = null): array;

    /**
 * 指定されたフィルタ条件、ソート順、およびページネーション設定に従い記事を取得する。
 *
 * 取得対象の記事は、フィルタ配列により絞り込みが行われ、指定された並び順にソートされた後、
 * 指定されたページ番号と1ページあたりの件数に基づいて返却されます。
 *
 * @param array $filters 取得対象を絞り込むための条件
 * @param string $sort 記事の並び順を指定する文字列
 * @param int $page 取得するページ番号（1から開始）
 * @param int $perPage 1ページあたりに取得する記事の件数
 * @return Article[] 条件に一致する記事の配列
 */
    public function findAll(array $filters, string $sort, int $page, int $perPage): array;

    /**
 * 指定された Article オブジェクトをリポジトリに保存します。
 *
 * このメソッドは、渡された記事インスタンスの永続化を契約しています。
 *
 * @param Article $article 保存する記事オブジェクト
 */
    public function save(Article $article): void;

    /**
 * 指定された記事を論理削除する
 *
 * 記事の削除フラグを設定し、論理削除状態に変更します。完全にデータを削除するのではなく、後で復元できるように保持します。
 *
 * @param Article $article 削除対象の記事オブジェクト
 */
    public function delete(Article $article): void;

    /**
 * 指定された記事オブジェクトをリポジトリから永久に削除します。
 *
 * このメソッドは、記事の論理削除ではなく、完全な削除を実施します。
 *
 * @param Article $article 削除対象の記事オブジェクト
 */
    public function forceDelete(Article $article): void;

    /**
 * 論理削除された記事を復元する.
 *
 * 指定された記事オブジェクトの削除状態を解除し、再び利用可能な状態に戻します。
 *
 * @param Article $article 復元対象の記事オブジェクト
 */
    public function restore(Article $article): void;

    /**
 * 指定された記事IDに対応する論理削除済みの記事を取得する。
 *
 * 指定されたIDの記事が論理削除されている場合、対応する記事オブジェクトを返します。
 * 記事が見つからない場合は null を返します。
 *
 * @param int $id 記事の一意識別子
 * @return Article|null 論理削除済みの記事オブジェクト、または記事が存在しない場合は null
 */
    public function findTrashedById(int $id): ?Article;
}
