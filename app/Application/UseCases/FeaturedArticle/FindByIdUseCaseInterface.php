<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\Entities\FeaturedArticle;
use App\Domain\ValueObjects\FeaturedArticleId;

interface FindByIdUseCaseInterface
{
    /**
     * 注目記事をIDで取得（存在しなければnull）
     */
    public function handle(FeaturedArticleId $id): ?FeaturedArticle;
}
