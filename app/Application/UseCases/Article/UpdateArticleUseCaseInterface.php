<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Application\DTOs\UpdateArticleInput;
use App\Domain\Entities\Article;

interface UpdateArticleUseCaseInterface
{
    public function execute(
        UpdateArticleInput $input,
    ): Article;
}
