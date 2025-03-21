<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\Entities\FeaturedArticle;
use App\Domain\ValueObjects\FeaturedArticleId;

interface FindByIdUseCaseInterface
{
    /**
 * 指定されたIDに対応する注目記事を取得する。
 *
 * 指定された注目記事IDに基づいて、該当する注目記事を検索し返却する。
 * 該当する記事が存在しない場合はnullを返す。
 *
 * @param FeaturedArticleId $id 注目記事のID。
 * @return FeaturedArticle|null 指定されたIDに対応する注目記事、存在しない場合はnull。
 */
    public function handle(FeaturedArticleId $id): ?FeaturedArticle;
}
