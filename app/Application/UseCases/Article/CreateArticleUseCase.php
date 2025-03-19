<?php

namespace App\Application\UseCases\Article;

use App\Domain\Entities\Article;
use App\Domain\Entities\ArticleService;
use App\Domain\Enums\ArticleStatus;
use App\Domain\Repositories\ArticleRepositoryInterface;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleTitle;
use DateTimeImmutable;

class CreateArticleUseCase implements CreateArticleUseCaseInterface
{
    public function __construct(private ArticleRepositoryInterface $articleRepository) {}

    public function execute(
        string $title,
        ArticleLink $link,
        ArticleStatus $status,
        ArticleService $service
    ): Article {
        $article = new Article(
            id: 0,
            title: new ArticleTitle($title),
            status: $status,
            service: $service,
            createdAt: new DateTimeImmutable,
            updatedAt: new DateTimeImmutable
        );

        $this->articleRepository->save($article);

        return $article;
    }
}
