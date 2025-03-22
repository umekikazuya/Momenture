<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

interface SearchArticlesUseCaseInterface
{
    /**
     * 指定された条件に従って記事を検索し、結果を配列として返します。
     *
     * オプションで指定された検索キーワード、サービスID、タグIDに基づき記事を絞り込みます。
     * 各パラメータが null の場合、その条件による絞り込みは行われません。
     *
     * @param  string|null $keyword   検索対象のキーワード。省略または
     *                                null
     *                                の場合、キーワードによる絞り込みは行いません。
     * @param  int|null    $serviceId 記事に関連するサービスの識別子。null
     *                                の場合、サービスによる絞り込みは行いません。
     * @param  int|null    $tagId     記事に関連するタグの識別子。null
     *                                の場合、タグによる絞り込みは行いません。
     * @return array 条件に一致する記事の配列。該当記事がない場合は空の配列が返されます。
     */
    public function execute(?string $keyword = null, ?int $serviceId = null, ?int $tagId = null): array;
}
