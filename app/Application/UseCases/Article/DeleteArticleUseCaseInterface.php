<?php

namespace App\Application\UseCases\Article;

interface DeleteArticleUseCaseInterface
{
    public function execute(int $id, bool $force = false): void;
}
