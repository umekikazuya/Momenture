<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\ArticleService;

interface ArticleServiceRepositoryInterface
{
    /**
 * すべてのArticleServiceエンティティを取得します。
 *
 * @return array ArticleServiceエンティティの配列
 */
public function findAll(): array;

    /**
 * 指定されたIDに対応するArticleServiceエンティティを取得します。
 *
 * 指定されたIDに基づいてArticleServiceエンティティを検索し、該当するエンティティが存在すれば返します。
 * 該当するエンティティが見つからない場合はnullを返します。
 *
 * @param int $id 検索対象となるArticleServiceエンティティの一意な識別子。
 * @return ArticleService|null 対応するArticleServiceエンティティが存在する場合はそのオブジェクト、見つからない場合はnull。
 */
public function findById(int $id): ?ArticleService;

    /**
 * 与えられた ArticleService エンティティを元に新規レコードを作成し、作成後のエンティティを返却します。
 *
 * @param ArticleService $articleService 作成対象の ArticleService インスタンス
 * @return ArticleService 作成された ArticleService エンティティ
 */
public function create(ArticleService $articleService): ArticleService;

    /**
 * 指定された ArticleService エンティティの内容を更新し、更新後のエンティティを返します。
 *
 * 渡された ArticleService オブジェクトの情報に基づいて、データソース上の対応するレコードを更新します。
 *
 * @param ArticleService $articleService 更新対象の ArticleService エンティティ。
 * @return ArticleService 更新後の ArticleService エンティティ。
 */
public function update(ArticleService $articleService): ArticleService;

    /**
 * 指定された ArticleService エンティティを削除する。
 *
 * @param ArticleService $articleService 削除対象の ArticleService エンティティ
 */
public function delete(ArticleService $articleService): void;

    /**
 * 指定された ArticleService エンティティを物理的に削除します。
 *
 * このメソッドは、ArticleService エンティティに対して論理削除ではなく、強制的な物理削除を実行します。
 *
 * @param ArticleService $articleService 削除対象の ArticleService エンティティ
 */
public function forceDelete(ArticleService $articleService): void;
}
