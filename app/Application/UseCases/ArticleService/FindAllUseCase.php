<?php

namespace App\Application\UseCases\ArticleService;

use App\Domain\Repositories\ArticleServiceRepositoryInterface;

class FindAllUseCase implements FindAllUseCaseInterface
{
    public function __construct(private ArticleServiceRepositoryInterface $articleServiceRepository)
    {
    }

    public function execute(): array
    {
        return $this->articleServiceRepository->findAll();
    }
}
