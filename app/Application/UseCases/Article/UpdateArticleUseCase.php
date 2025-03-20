<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Application\DTOs\UpdateArticleInput;
use App\Domain\Entities\Article;
use App\Domain\Repositories\ArticleRepositoryInterface;

class UpdateArticleUseCase implements UpdateArticleUseCaseInterface
{
    public function __construct(private ArticleRepositoryInterface $articleRepository) {}

    public function execute(
        UpdateArticleInput $input,
    ): Article {
        $article = $this->articleRepository->findById($input->id);

        if (! $article) {
            throw new \DomainException("記事が見つかりません。ID: {$input->id}");
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
