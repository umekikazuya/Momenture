<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Application\DTOs\UpdateArticleInput;
use App\Domain\Entities\Article;

interface UpdateArticleUseCaseInterface
{
    /**
     * 指定された入力データに基づいて記事を更新し、更新された記事を返します。
     *
     * このメソッドは、更新対象の記事の情報を含むDTO（UpdateArticleInput）を受け取り、記事更新の実行を委譲します。
     *
     * @param UpdateArticleInput $input 記事更新に必要な情報を含むDTO
     * @return Article 更新後の記事のインスタンス
     */
    public function execute(
        UpdateArticleInput $input,
    ): Article;
}
