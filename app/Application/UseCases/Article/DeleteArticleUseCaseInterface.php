<?php

namespace App\Application\UseCases\Article;

interface DeleteArticleUseCaseInterface
{
    /**
 * 指定された記事を削除する。
 *
 * 与えられた記事IDに対応する記事を削除します。$force が true の場合は、削除処理を強制的に実行します。
 *
 * @param int $id 削除対象の記事の識別子
 * @param bool $force 強制削除を実行する場合は true（初期値は false）
 */
public function execute(int $id, bool $force = false): void;
}
