<?php

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;
use DomainException;

class DeleteArticleUseCase implements DeleteArticleUseCaseInterface
{
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    public function execute(int $id, bool $force = false): void
    {
        $article = $this->articleRepository->findById($id);

        if (! $article) {
            throw new DomainException('記事が見つかりません。');
        }

        if ($force) {
            $this->articleRepository->forceDelete($article);
        } else {
            $this->articleRepository->delete($article);
        }
    }
}
