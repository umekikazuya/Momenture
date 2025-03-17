<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\FeaturedArticle;

interface FeaturedArticleRepositoryInterface
{
    public function findById(int $id): ?FeaturedArticle;

    public function findActive(): array;

    public function save(FeaturedArticle $featuredArticle): void;

    public function delete(FeaturedArticle $featuredArticle): void;
}
