<?php

namespace App\Application\UseCases\Article;

interface DeleteArticleUseCaseInterface
{
    /**
     * 指定された記事を削除する。
     *
     * 与えられた記事IDに基づき記事を削除し、必要に応じて強制削除を実行します。
     *
     * @param int  $id    削除対象の記事の識別子。
     * @param bool $force 強制削除を有効にする場合は true。デフォルトは false。
     */
    public function execute(int $id, bool $force = false): void;
}
