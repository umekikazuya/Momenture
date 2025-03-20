<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

interface SearchArticlesUseCaseInterface
{
    /**
 * 指定された条件に基づいて記事を検索し、検索結果の一覧を返すメソッド。
 *
 * 各パラメータがnullの場合、その条件は無視され、該当するすべての記事が対象となります。
 *
 * @param string|null $keyword 検索キーワード。nullの場合はキーワードが条件に含まれません。
 * @param int|null $serviceId 検索対象のサービスID。nullの場合はサービス条件が適用されません。
 * @param int|null $tagId 検索対象のタグID。nullの場合はタグ条件が適用されません。
 *
 * @return array 検索結果として見つかった記事情報の一覧。
 */
public function execute(?string $keyword = null, ?int $serviceId = null, ?int $tagId = null): array;
}
