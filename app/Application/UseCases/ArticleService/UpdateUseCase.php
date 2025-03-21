<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleServiceRepositoryInterface;

class UpdateUseCase implements UpdateUseCaseInterface
{
    public function __construct(private ArticleServiceRepositoryInterface $articleServiceRepository)
    {
    }

    public function execute(
        ArticleService $articleService,
    ): ArticleService {
        $this->articleServiceRepository->update($articleService);

        return $articleService;
    }
}
