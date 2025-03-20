<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Domain\Enums\ArticleStatus;
use App\Domain\Repositories\ArticleRepositoryInterface;

class ChangeArticleStatusUseCase implements ChangeArticleStatusUseCaseInterface
{
    /**
 * ChangeArticleStatusUseCase のインスタンスを初期化します。
 *
 * ArticleRepositoryInterface のインスタンスを受け取り、記事の状態変更に必要なリポジトリを内部に保持します。
 */
public function __construct(private ArticleRepositoryInterface $articleRepository) {}

    /**
     * 記事のステータスを更新する。
     *
     * 指定された記事IDに対応する記事を取得し、提供された新しいステータス文字列をArticleStatusに変換して
     * 状態を更新します。記事が見つからない場合や、新しいステータスが無効な場合は、それぞれ適切な例外をスローします。
     * なお、記事の現在のステータスと新しいステータスが同一の場合は更新処理を行いません。
     *
     * @param int $articleId 記事の識別子
     * @param string $newStatus 更新するステータス（ArticleStatusに変換可能な文字列）
     *
     * @throws \DomainException 指定された記事IDに対応する記事が存在しない場合
     * @throws \InvalidArgumentException 渡されたステータスが無効な場合
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
