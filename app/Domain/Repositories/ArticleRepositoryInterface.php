<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\Article;

interface ArticleRepositoryInterface
{
    /**
     * 指定された記事IDに一致する記事を取得します。
     *
     * 指定したIDの記事が存在する場合はArticleオブジェクトを返し、存在しない場合はnullを返します。
     *
     * @param  int  $id  取得する記事のID
     * @return Article|null 記事が存在する場合はArticleオブジェクト、存在しない場合はnull
     */
    public function findById(int $id): ?Article;

    /**
     * キーワードに基づいて記事を検索する。
     *
     * 指定のキーワードに加え、オプションでサービスIDおよびタグIDを指定することで、該当する記事の一覧を取得します。
     *
     * @param  string  $keyword  検索に使用するキーワード
     * @param  int|null  $serviceId  （任意）記事のサービスIDでフィルタリングする場合に指定
     * @param  int|null  $tagId  （任意）記事のタグIDでフィルタリングする場合に指定
     * @return Article[] 条件に一致する記事の配列
     */
    public function search(string $keyword, ?int $serviceId = null, ?int $tagId = null): array;

    /**
     * 指定のフィルター、ソート、ページ情報に基づいて記事一覧を取得する。
     *
     * 渡されたフィルター条件、ソート順、ページ番号、1ページあたりの件数に従って記事を検索し、一致する記事の配列を返します。
     *
     * @param  array  $filters  検索条件のフィルター連想配列
     * @param  string  $sort  記事のソート順を示す文字列
     * @param  int  $page  現在のページ番号（1以上の整数）
     * @param  int  $perPage  1ページあたりの取得件数
     * @return Article[] 条件に合致する記事一覧
     */
    public function findAll(array $filters, string $sort, int $page, int $perPage): array;

    /**
     * 指定された記事オブジェクトをリポジトリに保存します。
     *
     * @param  Article  $article  保存対象の記事オブジェクト
     */
    public function save(Article $article): void;

    /**
     * 指定された記事を論理削除します。
     *
     * この操作は記事に論理削除フラグを設定し、通常の表示および検索から除外しますが、後から復元可能です。
     *
     * @param  Article  $article  対象の記事オブジェクト
     */
    public function delete(Article $article): void;

    /**
     * 指定された記事を物理的に削除します。
     *
     * 論理削除ではなく、記事のデータがデータベースから完全に除去されるため、復元はできません。
     *
     * @param  Article  $article  削除対象の記事オブジェクト
     */
    public function forceDelete(Article $article): void;

    /**
     * 論理削除された記事を元の状態に復元する。
     *
     * 指定された記事が論理削除された状態の場合、その削除済みフラグを解除し、通常の状態に戻します。
     *
     * @param  Article  $article  復元対象の記事オブジェクト
     */
    public function restore(Article $article): void;

    /**
     * 指定された記事IDに対応する論理削除された記事を取得する。
     *
     * 指定したIDに基づいて論理削除状態にある記事を検索し、存在すればその Article オブジェクトを返します。
     * 該当する記事が見つからない場合は null を返します。
     *
     * @param  int  $id  記事の一意な識別子
     * @return ?Article 論理削除された記事が存在する場合は Article オブジェクト、存在しない場合は null
     */
    public function findTrashedById(int $id): ?Article;
}
