<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Application\DTOs\UpdateArticleInput;
use App\Domain\Entities\Article;

interface UpdateArticleUseCaseInterface
{
    /**
     * 指定した入力データに基づき記事の更新処理を実行し、更新後の記事オブジェクトを返す。
     *
     * このメソッドは、更新対象の記事情報を含む入力を受け取り、記事の状態を変更した結果として新たな記事オブジェクトを生成する。
     *
     * @param UpdateArticleInput $input 更新対象の記事情報を含む入力データ
     *
     * @return Article 更新後の記事オブジェクト
     */
    public function execute(
        UpdateArticleInput $input,
    ): Article;
}
