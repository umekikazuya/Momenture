<?php

namespace App\Application\UseCases\Article;

interface DeleteArticleUseCaseInterface
{
    /**
 * 指定された記事を削除します。
 *
 * 渡された記事IDを基に記事の削除を実行します。強制削除フラグがtrueの場合、通常の検証やチェックを省略して記事を強制的に削除します。
 *
 * @param int $id 削除対象の記事の識別子。
 * @param bool $force 強制削除を行う場合はtrue。
 */
public function execute(int $id, bool $force = false): void;
}
