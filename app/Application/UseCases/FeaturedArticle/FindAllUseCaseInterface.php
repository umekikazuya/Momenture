<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\Entities\FeaturedArticle;

interface FindAllUseCaseInterface
{
    /**
     * 有効な注目記事一覧を取得（優先度順）
     *
     * @return FeaturedArticle[]
     */
    public function handle(): array;
}
