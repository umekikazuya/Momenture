<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Domain\Entities\Article;
use App\Domain\Entities\ArticleService;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleTitle;

interface UpdateArticleUseCaseInterface
{
    public function execute(
        int $articleId,
        ?ArticleTitle $title,
        ?ArticleLink $link,
        ?ArticleService $service
    ): Article;
}
