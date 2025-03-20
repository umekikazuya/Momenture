<?php

namespace App\Application\UseCases\Article;

use App\Domain\Entities\Article;

interface FindArticleByIdUseCaseInterface
{
    /**
 * 指定された記事IDに基づいて記事を取得する。
 *
 * 与えられた記事IDに対応する記事を検索し、見つかった場合はArticleオブジェクトを返します。
 * 存在しない場合はnullを返します。
 *
 * @param int $articleId 検索対象の記事のID
 * @return Article|null 該当する記事が存在する場合はArticleオブジェクト、存在しない場合はnull
 */
public function execute(int $articleId): ?Article;
}
