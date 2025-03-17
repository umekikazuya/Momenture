<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Domain\Entities\Article;
use App\Domain\Entities\ArticleService;
use App\Domain\Enums\ArticleStatus;

interface CreateArticleUseCaseInterface
{
    public function execute(string $title, ArticleStatus $status, ArticleService $service): Article;
}
