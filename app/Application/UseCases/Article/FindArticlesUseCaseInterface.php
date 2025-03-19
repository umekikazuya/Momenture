<?php

namespace App\Application\UseCases\Article;

interface FindArticlesUseCaseInterface
{
    public function execute(array $filters, string $sort, int $page, int $perPage): array;
}
