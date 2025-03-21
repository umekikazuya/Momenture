<?php

declare(strict_types=1);

namespace App\Application\UseCases\FeaturedArticle;

use App\Domain\ValueObjects\FeaturedArticleId;

interface DeactivateUseCaseInterface
{
    /**
 * 指定された注目記事の無効化を実行する。
 *
 * 与えられた注目記事識別子に基づき、その記事の無効化処理を行います。
 *
 * @param FeaturedArticleId $id 無効化対象の注目記事識別子
 * @throws \DomainException 無効化が実行できない場合にスローされる例外
 */
    public function handle(FeaturedArticleId $id): void;
}
