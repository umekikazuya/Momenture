<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Domain\Repositories\ArticleServiceRepositoryInterface;

class FindAllUseCase implements FindAllUseCaseInterface
{
    public function __construct(private ArticleServiceRepositoryInterface $repository)
    {
    }

    public function execute(): array
    {
        try {
            return $this->repository->findAll();
        } catch (\Exception $e) {
            throw new \RuntimeException('記事サービスの取得中にエラーが発生しました', 0, $e);
        }
    }
}
