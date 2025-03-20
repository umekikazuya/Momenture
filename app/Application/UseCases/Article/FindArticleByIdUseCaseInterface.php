<?php

namespace App\Application\UseCases\Article;

use App\Domain\Entities\Article;

interface FindArticleByIdUseCaseInterface
{
    /**
 * 指定した記事IDに対応する記事を検索する。
 *
 * 指定されたIDと一致する記事が存在する場合はそのArticleオブジェクトを返し、
 * 存在しない場合はnullを返します。
 *
 * @param int $articleId 検索対象の記事のID
 *
 * @return Article|null 記事が見つかった場合はArticleオブジェクト、見つからなかった場合はnull
 */
public function execute(int $articleId): ?Article;
}
