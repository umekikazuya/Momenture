<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Domain\Entities\ArticleService;

interface UpdateUseCaseInterface
{
    /**
     * 記事サービスの更新処理を実行する。
     *
     * 渡された ArticleService インスタンスに対して更新操作を行い、更新後のインスタンスを返却します。
     *
     * @param  ArticleService $articleService 更新対象の記事サービスインスタンス
     * @return ArticleService 更新後の記事サービスインスタンス
     *
     * @throws \DomainException 更新処理に失敗した場合にスローされます
     */
    public function execute(
        ArticleService $articleService,
    ): ArticleService;
}
