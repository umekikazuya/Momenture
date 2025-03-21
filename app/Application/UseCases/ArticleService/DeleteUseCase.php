<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Domain\Repositories\ArticleServiceRepositoryInterface;

class DeleteUseCase implements DeleteUseCaseInterface
{
    public function __construct(private ArticleServiceRepositoryInterface $articleServiceRepository) {
    }

    public function execute(int $id, bool $force = false): void
    {
        try {
            $article = $this->articleServiceRepository->findById($id);
            if (! $article) {
                throw new \DomainException("ID: {$id} の記事サービスが見つかりません。");
            }
            if ($force) {
                $this->articleServiceRepository->forceDelete($article);
            } else {
                $this->articleServiceRepository->delete($article);
            }
        } catch (\DomainException $e) {
        } catch (\Exception $e) {
            throw new \RuntimeException("ID: {$id} の記事サービスの削除中にエラーが発生しました", 0, $e);
        }

    }
}
