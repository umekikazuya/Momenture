<?php

namespace App\Application\UseCases\Article;

use App\Application\Dtos\UpdateArticleInput;
use App\Domain\Entities\Article;
use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleRepositoryInterface;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleTitle;

class UpdateArticleUseCase implements UpdateArticleUseCaseInterface
{
    public function __construct(private ArticleRepositoryInterface $articleRepository) {}

    public function execute(
        UpdateArticleInput $input,
    ): Article {
        $article = $this->articleRepository->findById($input->id);

        if (! $article) {
            throw new \DomainException('記事が見つかりません。');
        }

        if ($input->title !== null) {
            $article->updateTitle($input->title);
        }

        if ($input->link !== null) {
            $article->updateLink($input->link);
        }

        if ($input->service !== null) {
            $article->updateArticleService($input->service);
        }

        $this->articleRepository->save($article);

        return $article;
    }
}
