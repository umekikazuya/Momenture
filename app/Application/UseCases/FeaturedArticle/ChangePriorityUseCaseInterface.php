<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\ValueObjects\FeaturedArticleId;
use App\Domain\ValueObjects\FeaturedPriority;

interface ChangePriorityUseCaseInterface
{
    /**
     * 注目記事の優先度を更新する。
     *
     * 指定された注目記事の識別子と優先度に基づき、該当記事の表示順位を更新します。
     * 更新が実現できない場合は DomainException をスローします。
     *
     * @param FeaturedArticleId $id       対象の注目記事の識別子
     * @param FeaturedPriority  $priority 設定する新しい優先度
     *
     * @throws \DomainException 優先度の更新が不可能な場合
     */
    public function handle(FeaturedArticleId $id, FeaturedPriority $priority): void;
}
