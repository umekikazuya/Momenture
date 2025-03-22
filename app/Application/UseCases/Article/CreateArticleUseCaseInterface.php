<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Application\DTOs\CreateArticleInput;
use App\Domain\Entities\Article;

interface CreateArticleUseCaseInterface
{
    /**
     * 指定された入力データに基づいて記事を作成し、Articleエンティティを返す。
     *
     * 渡されたCreateArticleInput DTOから必要な情報を取得し、新規の記事エンティティを生成します。
     *
     * @param  CreateArticleInput $dto 記事作成に必要なデータを保持するDTO
     * @return Article 作成された記事エンティティ
     */
    public function execute(CreateArticleInput $dto): Article;
}
