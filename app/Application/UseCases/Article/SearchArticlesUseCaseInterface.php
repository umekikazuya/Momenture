<?php

namespace App\Application\UseCases\Article;

interface SearchArticlesUseCaseInterface
{
    public function execute(string $keyword, ?int $serviceId = null, ?int $tagId = null): array;
}
