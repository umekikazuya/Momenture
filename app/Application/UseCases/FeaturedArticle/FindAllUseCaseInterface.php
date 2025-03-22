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
     *
     * @throws \RuntimeException DBエラーが発生した場合
     */
    public function handle(): array;
}
