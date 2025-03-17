<?php

namespace App\Application\UseCases\Article;

use App\Domain\Entities\Article;
use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleRepositoryInterface;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleTitle;

class UpdateArticleUseCase implements UpdateArticleUseCaseInterface
{
    public function __construct(private ArticleRepositoryInterface $articleRepository) {}

    public function execute(
        int $articleId,
        ?ArticleTitle $title,
        ?ArticleLink $link,
        ?ArticleService $service
    ): Article {
        $article = $this->articleRepository->findById($articleId);

        if (! $article) {
            throw new \DomainException('記事が見つかりません。');
        }

        if ($title !== null) {
            $article->updateTitle($title);
        }

        if ($link !== null) {
            $article->updateLink($link);
        }

        if ($service !== null) {
            $article->updateArticleService($service);
        }

        $this->articleRepository->save($article);

        return $article;
    }
}
