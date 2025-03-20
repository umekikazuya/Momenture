<?php

namespace App\Application\UseCases\Article;

use App\Domain\Entities\Article;

interface FindArticleByIdUseCaseInterface
{
    /**
 * 指定された記事IDをもとに記事を検索し、見つかった場合は記事オブジェクトを返す。
 *
 * 与えられた記事IDから該当する記事を検索し、記事が存在する場合はその記事オブジェクトを返し、存在しない場合は null を返す。
 *
 * @param int $articleId 記事の一意の識別子
 * @return Article|null 該当する記事オブジェクト、もしくは記事が存在しない場合は null
 */
public function execute(int $articleId): ?Article;
}
