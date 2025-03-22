<?php

namespace App\Application\UseCases\Article;

interface RestoreArticleUseCaseInterface
{
    /**
     * 指定された記事IDを元に記事を復元。
     *
     * @param int $id 復元対象の記事ID
     *
     * @throws \DomainException 指定されたIDに対応する記事が存在しない場合
     * @throws \RuntimeException データベースエラーなど、予期しない例外が発生した場合
     */
    public function execute(int $id): void;
}
