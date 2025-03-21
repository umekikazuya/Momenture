<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Domain\Entities\ArticleService;

interface FindByIdUseCaseInterface
{
    /**
     * 指定した記事IDに基づいて記事のサービスインスタンスを取得する。
     *
     * 指定されたIDと一致する記事が存在する場合は、対応するArticleServiceオブジェクトを返し、
     * 存在しない場合はnullを返します。
     *
     * @param int $id 検索対象の記事のID
     *
     * @return ArticleService|null 該当する記事が存在する場合はArticleServiceのインスタンス、存在しない場合はnull
     */
    public function execute(int $id): ?ArticleService;
}
