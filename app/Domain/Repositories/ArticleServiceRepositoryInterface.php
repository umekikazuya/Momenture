<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\ArticleService;

interface ArticleServiceRepositoryInterface
{
    public function findAll(): array;

    public function findById(int $id): ?ArticleService;

    public function create(ArticleService $article): ArticleService;

    public function update(ArticleService $article): ArticleService;

    public function delete(ArticleService $article): void;

    public function forceDelete(ArticleService $article): void;
}
