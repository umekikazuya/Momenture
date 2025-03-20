<?php

namespace App\Application\UseCases\Article;

interface RestoreArticleUseCaseInterface
{
    /**
 * 指定された記事IDに基づいて記事の復元処理を実行します。
 *
 * @param int $articleId 復元する記事の識別子
 */
public function execute(int $articleId): void;
}
