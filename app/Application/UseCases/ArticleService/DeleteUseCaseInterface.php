<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

interface DeleteUseCaseInterface
{
    /**
     * 指定された記事の削除処理を実行する。
     *
     * 提供された記事IDに基づいて記事を削除します。$force が true の場合は、通常の削除制御を無視して強制的に削除を実行します。
     *
     * @param int  $id    削除対象の記事の識別子
     * @param bool $force 強制削除を実行する場合は true（省略時は false）
     */
    public function execute(int $id, bool $force = false): void;
}
