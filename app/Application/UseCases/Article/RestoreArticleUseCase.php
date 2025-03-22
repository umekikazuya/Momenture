<?php

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;

class RestoreArticleUseCase implements RestoreArticleUseCaseInterface
{
    /**
     * コンストラクタ。
     *
     * ArticleRepositoryInterface のインスタンスを受け取り、記事の復元処理に必要なリポジトリとして内部に保持。
     */
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function execute(int $id): void
    {
        try {
            $entity = $this->articleRepository->findTrashedById($id);
            $this->articleRepository->restore($entity);
        } catch (\DomainException $e) {
            throw $e;
        } catch (\RuntimeException $e) {
            throw $e;
        }
    }
}
