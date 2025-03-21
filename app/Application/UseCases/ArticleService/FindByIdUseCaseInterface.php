<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Domain\Entities\ArticleService;

interface FindByIdUseCaseInterface
{
    public function execute(int $id): ?ArticleService;
}
