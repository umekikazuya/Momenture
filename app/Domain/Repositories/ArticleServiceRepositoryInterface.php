<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\ArticleService;

interface ArticleServiceRepositoryInterface
{
    /**
 * 指定されたIDに対応するArticleServiceエンティティを取得します。
 *
 * 指定された一意のIDを使用して、ArticleServiceエンティティを検索します。
 * 該当するエンティティが見つからない場合はnullを返します。
 *
 * @param int $id 検索対象のArticleServiceエンティティの一意な識別子
 *
 * @return ArticleService|null 該当するエンティティが存在しない場合はnull
 */
public function findById(int $id): ?ArticleService;

    /**
 * 指定された名前に一致する ArticleService を返します。
 *
 * このメソッドは、与えられた名前に基づいて ArticleService エンティティを検索し、
 * 一致するエンティティが存在する場合はそのオブジェクト、存在しない場合は null を返します。
 *
 * @param string $name 検索対象の名前
 *
 * @return ArticleService|null 見つかった ArticleService オブジェクト、または存在しない場合は null
 */
public function findByName(string $name): ?ArticleService;

    /**
 * ArticleServiceエンティティを保存する。
 *
 * 指定されたArticleServiceオブジェクトをデータストアに永続化します。
 *
 * @param ArticleService $service 保存対象のArticleServiceエンティティ
 */
public function save(ArticleService $service): void;
}
