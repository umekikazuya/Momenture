<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

interface FindAllUseCaseInterface
{
    /**
 * 全記事の一覧を取得して返す。
 *
 * 実装クラスでは記事の取得処理を実装し、記事データを配列として返すことが求められます。
 *
 * @return array 取得した記事情報の一覧
 */
public function execute(): array;
}
