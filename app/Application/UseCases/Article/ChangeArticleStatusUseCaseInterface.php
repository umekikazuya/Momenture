<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

interface ChangeArticleStatusUseCaseInterface
{
    /**
 * 指定された記事IDの状態を、新しい状態に変更します。
 *
 * @param int $articleId 記事の識別子
 * @param string $newStatus 記事の新しい状態を表す文字列
 */
public function execute(int $articleId, string $newStatus): void;
}
