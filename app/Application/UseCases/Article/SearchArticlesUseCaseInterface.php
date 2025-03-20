<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

interface SearchArticlesUseCaseInterface
{
    public function execute(?string $keyword = null, ?int $serviceId = null, ?int $tagId = null): array;
}
