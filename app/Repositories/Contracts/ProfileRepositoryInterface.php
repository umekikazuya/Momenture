<?php

namespace App\Repositories\Contracts;

use App\Models\Profile;

interface ProfileRepositoryInterface
{
    public function findById(string $id): ?Profile;

    public function save(Profile $profile): void;

    public function delete(string $id): void;
}
