<?php

namespace App\Application\UseCases\Article;

use App\Domain\Enums\ArticleStatus;
use App\Domain\Repositories\ArticleRepositoryInterface;
use DomainException;

class ChangeArticleStatusUseCase implements ChangeArticleStatusUseCaseInterface
{
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    public function execute(int $articleId, string $newStatus): void
    {
        $article = $this->articleRepository->findById($articleId);

        if (! $article) {
            throw new DomainException('記事が見つかりません。');
        }

        if (! ArticleStatus::tryFrom($newStatus)) {
            throw new DomainException('無効なステータスです。');
        }

        $article->updateStatus(ArticleStatus::from($newStatus));

        $this->articleRepository->save($article);
    }
}
