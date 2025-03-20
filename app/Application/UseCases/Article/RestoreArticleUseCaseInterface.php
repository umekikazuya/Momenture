<?php

namespace App\Application\UseCases\Article;

interface RestoreArticleUseCaseInterface
{
    /**
 * 指定された記事IDに対応する記事を復元します。
 *
 * @param int $articleId 復元対象の記事のID。
 */
public function execute(int $articleId): void;
}
