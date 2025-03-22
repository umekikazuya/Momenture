<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Domain\Entities\ArticleService;
use App\Domain\ValueObjects\ArticleServiceId;

interface FindByIdUseCaseInterface
{
    /**
     * 指定した記事IDに基づいて記事のサービスインスタンスを取得する。
     *
     * 指定されたIDと一致する記事が存在する場合は、対応するArticleServiceオブジェクトを返し、
     * 存在しない場合はnullを返します。
     *
     * @param  ArticleServiceId $id 検索対象の記事のID
     * @return ArticleService 該当する記事が存在する場合はArticleServiceのインスタンスを返す
     *
     * @throws \DomainException 指定されたIDに対応する記事が存在しない場合
     * @throws \RuntimeException データベースエラーなど、予期しない例外が発生した場合
     */
    public function execute(ArticleServiceId $id): ArticleService;
}
