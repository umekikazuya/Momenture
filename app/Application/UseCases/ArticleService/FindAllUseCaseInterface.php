<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

interface FindAllUseCaseInterface
{
    public function execute(): array;
}
