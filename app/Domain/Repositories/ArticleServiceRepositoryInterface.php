<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\ArticleService;

interface ArticleServiceRepositoryInterface
{
    /**
 * 指定されたIDに対応するArticleServiceエンティティを取得します。
 *
 * 指定されたIDを基にArticleServiceエンティティを検索し、一致するエンティティが存在すれば返し、
 * 存在しない場合はnullを返します。
 *
 * @param int $id ArticleServiceのユニーク識別子
 * @return ArticleService|null 一致するArticleServiceエンティティ、存在しない場合はnull
 */
public function findById(int $id): ?ArticleService;

    /**
 * 指定された名前に一致する ArticleService エンティティを検索する。
 *
 * 該当する ArticleService が存在しない場合、null を返します。
 *
 * @param string $name 検索対象の ArticleService 名
 * @return ArticleService|null 検索結果として見つかった ArticleService エンティティ、存在しない場合は null
 */
public function findByName(string $name): ?ArticleService;

    /**
 * 指定された ArticleService エンティティを保存します。
 *
 * 渡された ArticleService オブジェクトをデータベースなどのストレージに永続化します。
 *
 * @param ArticleService $service 保存対象の ArticleService エンティティ。
 */
public function save(ArticleService $service): void;
}
