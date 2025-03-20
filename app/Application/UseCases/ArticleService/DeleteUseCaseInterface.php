<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

interface DeleteUseCaseInterface
{
    public function execute(int $id, bool $force = false): void;
}
