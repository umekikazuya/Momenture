<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

interface ChangeArticleStatusUseCaseInterface
{
    /**
     * 記事の状態を変更する。
     *
     * 指定された記事IDに対応する記事の状態を、新しい状態に更新します。
     *
     * @param  int  $articleId  記事の一意識別子
     * @param  string  $newStatus  設定する新しい記事の状態
     */
    public function execute(int $articleId, string $newStatus): void;
}
