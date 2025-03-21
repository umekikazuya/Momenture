<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Application\UseCases\ArticleService\FindByIdUseCaseInterface;
use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleServiceRepositoryInterface;

class FindByIdUseCase implements FindByIdUseCaseInterface
{
    public function __construct(private ArticleServiceRepositoryInterface $repository)
    {
    }

    public function execute(int $id): ?ArticleService
    {
        return $this->repository->findById($id);
    }
}
