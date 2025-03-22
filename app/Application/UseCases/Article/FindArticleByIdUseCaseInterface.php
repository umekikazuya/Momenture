<?php

namespace App\Application\UseCases\Article;

use App\Domain\Entities\Article;

interface FindArticleByIdUseCaseInterface
{
    /**
     * 指定した記事IDに対応する記事を検索する。
     *
     * 指定されたIDと一致する記事が存在する場合はそのArticleオブジェクトを返す。
     *
     * @param int $articleId 検索対象の記事のID
     *
     * @return Article 記事が見つかった場合はArticleオブジェクト
     *
     * @throws \DomainException 指定されたIDに対応する記事が存在しない場合
     * @throws \RuntimeException データベースエラーなど、予期しない例外が発生した場合
     */
    public function execute(int $articleId): Article;
}
