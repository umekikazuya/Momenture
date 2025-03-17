<?php

namespace App\Application\UseCases\Article;

use App\Domain\Entities\Article;

interface FindArticleByIdUseCaseInterface
{
    public function execute(int $articleId): ?Article;
}
