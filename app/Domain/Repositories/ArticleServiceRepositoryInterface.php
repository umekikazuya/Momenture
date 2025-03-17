<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\ArticleService;

interface ServiceRepositoryInterface
{
    public function findById(int $id): ?ArticleService;

    public function findByName(string $name): ?ArticleService;

    public function save(ArticleService $service): void;
}
