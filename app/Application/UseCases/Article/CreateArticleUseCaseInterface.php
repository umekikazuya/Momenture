<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Application\DTOs\CreateArticleInput;
use App\Domain\Entities\Article;

interface CreateArticleUseCaseInterface
{
    /**
 * 入力DTOに基づいて記事を生成し、作成されたArticleエンティティを返します。
 *
 * 渡されたCreateArticleInputオブジェクトから必要な情報を抽出し、記事作成処理を実行します。
 *
 * @param CreateArticleInput $dto 記事作成に必要なデータを格納したDTO
 * @return Article 作成されたArticleエンティティ
 */
public function execute(CreateArticleInput $dto): Article;
}
