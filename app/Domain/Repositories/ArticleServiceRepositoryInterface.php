<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\ArticleService;

interface ArticleServiceRepositoryInterface
{
    /**
 * 指定されたIDに対応するArticleServiceエンティティを取得します。
 *
 * 指定したIDと一致するArticleServiceエンティティが存在する場合、そのオブジェクトを返し、存在しない場合はnullを返します。
 *
 * @param int $id 検索対象のエンティティID
 * @return ArticleService|null 該当するArticleServiceオブジェクト、または見つからなかった場合はnull
 */
public function findById(int $id): ?ArticleService;

    /**
 * 指定した名前に一致する ArticleService エンティティを取得する。
 *
 * 指定された名前で検索を行い、一致する ArticleService が存在する場合はそのエンティティを返します。
 * 存在しない場合は null を返します。
 *
 * @param string $name 検索対象の ArticleService の名前。
 * @return ArticleService|null 指定された名前に対応する ArticleService エンティティ、または存在しない場合は null。
 */
public function findByName(string $name): ?ArticleService;

    /**
 * 指定されたArticleServiceエンティティを保存する。
 *
 * このメソッドは引数として渡されたArticleServiceエンティティをデータストアに永続化します。
 *
 * @param ArticleService $service 保存対象のArticleServiceエンティティ
 */
public function save(ArticleService $service): void;
}
