<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Application\DTOs\UpdateArticleInput;
use App\Domain\Entities\Article;
use App\Domain\Repositories\ArticleRepositoryInterface;

class UpdateArticleUseCase implements UpdateArticleUseCaseInterface
{
    /**
     * ArticleRepositoryInterface を内部プロパティとして設定し、記事の更新処理に利用します。
     */
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function execute(
        UpdateArticleInput $input,
    ): Article {
        try {
            $entity = $this->articleRepository->findById($input->id);

            // エンティティの更新
            if ($input->title !== null) {
                $entity->updateTitle($input->title);
            }

            if ($input->link !== null) {
                $entity->updateLink($input->link);
            }

            if ($input->service !== null) {
                $entity->updateArticleService($input->service);
            }
            // モデルの更新
            $this->articleRepository->save($entity);

            return $entity;
        } catch (\DomainException $e) {
            throw $e;
        } catch (\RuntimeException $e) {
            throw $e;
        }
    }
}
