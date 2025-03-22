<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Domain\Entities\ArticleService;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;

interface UpdateUseCaseInterface
{
    /**
     * 記事サービスの更新処理を実行する。
     *
     * 渡された ArticleService インスタンスに対して更新操作を行い、更新後のインスタンスを返却。
     *
     * @param  ArticleServiceId   $id   更新対象の記事サービスの識別子
     * @param  ArticleServiceName $name 更新後の記事サービス名
     * @return ArticleService 更新後の記事サービスインスタンス
     *
     * @throws \DomainException 更新処理に失敗した場合にスロー。
     * @throws \RuntimeException データベースエラーなど、予期しない例外が発生した場合にスロー。
     */
    public function execute(
        ArticleServiceId $id,
        ArticleServiceName $name,
    ): ArticleService;
}
