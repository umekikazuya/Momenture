<?php

namespace App\Application\UseCases\Article;

interface DeleteArticleUseCaseInterface
{
    public function execute(int $articleId, bool $forceDelete = false): void;
}
