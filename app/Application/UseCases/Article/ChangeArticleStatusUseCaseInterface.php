<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

interface ChangeArticleStatusUseCaseInterface
{
    public function execute(int $articleId, string $newStatus): void;
}
