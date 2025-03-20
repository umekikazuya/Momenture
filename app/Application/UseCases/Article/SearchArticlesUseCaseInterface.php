<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

interface SearchArticlesUseCaseInterface
{
    /**
 * 指定された条件に基づいて記事を検索します。
 *
 * キーワード、サービスID、タグIDをフィルタ条件として使用し、一致する記事の一覧を返します。各パラメータが null の場合、その条件は検索処理に反映されません。
 *
 * @param string|null $keyword 検索対象のキーワード（記事のタイトルや内容）。
 * @param int|null $serviceId 関連サービスのIDによるフィルタリングに使用。
 * @param int|null $tagId 記事に付与されたタグのIDによるフィルタリングに使用。
 *
 * @return array 検索結果として一致した記事の一覧。
 */
public function execute(?string $keyword = null, ?int $serviceId = null, ?int $tagId = null): array;
}
