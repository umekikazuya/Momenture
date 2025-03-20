<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\ArticleService;

interface ArticleServiceRepositoryInterface
{
    public function findAll(): array;

    public function findById(int $articleServiceId): ?ArticleService;

    public function create(ArticleService $articleService): ArticleService;

    public function update(ArticleService $articleService): ArticleService;

    public function delete(ArticleService $articleService): void;

    public function forceDelete(ArticleService $articleService): void;
}
