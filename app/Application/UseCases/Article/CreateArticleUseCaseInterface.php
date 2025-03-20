<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Application\DTOs\CreateArticleInput;
use App\Domain\Entities\Article;

interface CreateArticleUseCaseInterface
{
    public function execute(CreateArticleInput $dto): Article;
}
