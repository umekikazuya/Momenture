<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Application\DTOs\CreateArticleInput;
use App\Domain\Entities\Article;

interface CreateArticleUseCaseInterface
{
    /**
 * 指定されたDTOの内容に基づき記事を作成し、生成されたArticleエンティティを返します。
 *
 * @param CreateArticleInput $dto 記事作成に必要なデータを含むDTO
 * @return Article 作成された記事のエンティティ
 */
public function execute(CreateArticleInput $dto): Article;
}
