<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;

class DeleteArticleUseCase implements DeleteArticleUseCaseInterface
{
    /**
     * DeleteArticleUseCase インスタンスを初期化する。
     *
     * このコンストラクタは記事の取得や削除操作に必要なリポジトリを注入します。
     */
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function execute(int $id, bool $force = false): void
    {
        try {
            $entity = $this->articleRepository->findById($id);
            if ($force) {
                $this->articleRepository->forceDelete($entity);
            } else {
                $this->articleRepository->delete($entity);
            }
        } catch (\DomainException $e) {
            throw $e;
        } catch (\RuntimeException $e) {
            throw new \RuntimeException('データベースエラーが発生しました。', 0, $e);
        }
    }
}
