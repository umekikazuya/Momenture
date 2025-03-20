<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Domain\Enums\ArticleStatus;
use App\Domain\Repositories\ArticleRepositoryInterface;

class ChangeArticleStatusUseCase implements ChangeArticleStatusUseCaseInterface
{
    /**
 * ChangeArticleStatusUseCaseのインスタンスを初期化する。
 *
 * 記事の状態変更処理に必要なArticleRepositoryInterfaceを注入し、内部でデータ操作を行います。
 */
public function __construct(private ArticleRepositoryInterface $articleRepository) {}

    /**
     * 指定された記事の状態を更新する。
     *
     * 指定された記事IDに対応する記事を取得し、存在しなければ DomainException をスローします。
     * また、提供された新しいステータスが無効な場合は InvalidArgumentException をスローします。
     * 既に記事が同じ状態の場合は更新処理を行いません。
     *
     * @param int $articleId 記事の識別子
     * @param string $newStatus 更新後のステータスを示す文字列
     *
     * @throws \DomainException 記事が存在しない場合
     * @throws \InvalidArgumentException 無効なステータスが指定された場合
     */
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
