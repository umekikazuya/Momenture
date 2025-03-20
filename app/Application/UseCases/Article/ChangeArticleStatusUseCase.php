<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Domain\Enums\ArticleStatus;
use App\Domain\Repositories\ArticleRepositoryInterface;

class ChangeArticleStatusUseCase implements ChangeArticleStatusUseCaseInterface
{
    public function __construct(private ArticleRepositoryInterface $articleRepository) {}

    public function execute(int $articleId, string $newStatus): void
    {
        $article = $this->articleRepository->findById($articleId);

        if (! $article) {
            throw new \DomainException("記事が見つかりません。ID: {$articleId}");
        }

        $newStatusEnum = ArticleStatus::tryFrom($newStatus);

        if (! $newStatusEnum) {
            throw new \InvalidArgumentException("無効なステータスです: {$newStatus}");
        }

        // 同じステータスの場合は更新しない
        if ($article->status() === $newStatusEnum) {
            return;
        }

        $article->updateStatus(ArticleStatus::from($newStatus));

        $this->articleRepository->save($article);
    }
}
