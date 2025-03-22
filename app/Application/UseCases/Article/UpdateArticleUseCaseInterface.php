<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Application\DTOs\UpdateArticleInput;
use App\Domain\Entities\Article;

interface UpdateArticleUseCaseInterface
{
    /**
     * 入力された更新情報に基づいて記事を更新し、更新後の記事オブジェクトを返します。
     *
     * 渡されたデータを使用して記事の更新処理を実行します。
     *
     * @param UpdateArticleInput $input 更新操作に必要な入力データを含むオブジェクト。
     *
     * @return Article 更新された記事オブジェクト。
     *
     * @throws \DomainException 更新処理に失敗した場合にスロー。
     * @throws \RuntimeException データベースエラーなど、予期しない例外が発生した場合にスロー。
     */
    public function execute(
        UpdateArticleInput $input,
    ): Article;
}
