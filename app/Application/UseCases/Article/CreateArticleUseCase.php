<?php

namespace App\Application\UseCases\Article;

use App\Application\DTOs\CreateArticleInput;
use App\Domain\Entities\Article;
use App\Domain\Repositories\ArticleRepositoryInterface;

class CreateArticleUseCase implements CreateArticleUseCaseInterface
{
    public function __construct(
        private ArticleRepositoryInterface $articleRepository
    ) {
    }

    public function execute(
        CreateArticleInput $dto
    ): Article {
        $article = new Article(
            id: 0,
            title: $dto->title,
            link: $dto->link,
            status: $dto->status,
            service: $dto->service,
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
        );
        $this->articleRepository->save($article);
        return $article;
    }
}
