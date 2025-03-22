<?php

namespace App\Application\UseCases\Article;

use App\Application\DTOs\CreateArticleInput;
use App\Domain\Entities\Article;
use App\Domain\Repositories\ArticleRepositoryInterface;

class CreateArticleUseCase implements CreateArticleUseCaseInterface
{
    /**
     * コンストラクタ
     *
     * 記事リポジトリのインスタンスを受け取り、記事作成ユースケースの初期化を行います。
     */
    public function __construct(
        private ArticleRepositoryInterface $articleRepository
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function execute(
        CreateArticleInput $dto
    ): Article {
        $article = new Article(
            id: 0,
            title: $dto->title,
            link: $dto->link,
            status: $dto->status,
            service: $dto->service,
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
        );
        $this->articleRepository->save($article);
        return $article;
    }
}
