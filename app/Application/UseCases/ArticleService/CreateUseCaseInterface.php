<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Domain\Entities\ArticleService;

interface CreateUseCaseInterface
{
    /**
     * 指定された名前に基づき記事サービスのインスタンスを生成して返却する。
     *
     * @param  string $name 記事サービス生成に使用する名称。
     * @return ArticleService 生成された記事サービスのインスタンス。
     *
     * @throws \RuntimeException データベースエラーなど、予期しない例外が発生した場合にスロー。
     */
    public function execute(string $name): ArticleService;
}
