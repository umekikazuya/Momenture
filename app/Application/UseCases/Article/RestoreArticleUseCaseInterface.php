<?php

namespace App\Application\UseCases\Article;

interface RestoreArticleUseCaseInterface
{
    public function execute(int $articleId): void;
}
