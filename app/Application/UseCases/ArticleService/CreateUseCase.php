<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleServiceRepositoryInterface;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;

class CreateUseCase implements CreateUseCaseInterface
{
    public function __construct(
        private ArticleServiceRepositoryInterface $articleRepository
    ) {
    }

    public function execute(string $name): ArticleService
    {
        $article = new ArticleService(
            id: new ArticleServiceId(0),
            name: new ArticleServiceName($name),
        );
        $this->articleRepository->create($article);
        return $article;
    }
}
