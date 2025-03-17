<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Tag;

interface TagRepositoryInterface
{
    public function findById(int $id): ?Tag;

    public function findByName(string $name): ?Tag;

    public function save(Tag $tag): void;

    public function delete(Tag $tag): void;
}
