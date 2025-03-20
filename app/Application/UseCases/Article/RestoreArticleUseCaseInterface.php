<?php

namespace App\Application\UseCases\Article;

interface RestoreArticleUseCaseInterface
{
    /**
 * 指定された記事IDを元に記事を復元します。
 *
 * @param int $articleId 復元対象の記事ID
 */
public function execute(int $articleId): void;
}
