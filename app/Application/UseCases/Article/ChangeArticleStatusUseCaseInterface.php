<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

interface ChangeArticleStatusUseCaseInterface
{
    /**
 * 指定された記事の状態を変更する。
 *
 * 記事IDで指定された記事の状態を、新しい状態に変更する処理を定義します。
 *
 * @param int $articleId 記事ID
 * @param string $newStatus 新しい記事の状態
 */
public function execute(int $articleId, string $newStatus): void;
}
