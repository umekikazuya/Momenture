<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Domain\Enums\ArticleStatus;
use App\Domain\Repositories\ArticleRepositoryInterface;

class ChangeArticleStatusUseCase implements ChangeArticleStatusUseCaseInterface
{
    /**
 * コンストラクタ.
 *
 * ArticleRepositoryInterface のインスタンスを受け取り、記事の状態変更ユースケースを初期化する。
 */
public function __construct(private ArticleRepositoryInterface $articleRepository) {}

    /**
     * 指定された記事のステータスを更新する。
     *
     * 記事IDを用いて記事を取得し、取得できなければ DomainException をスローします。
     * 新しいステータス文字列を ArticleStatusEnum に変換できない場合は InvalidArgumentException をスローします。
     * 現在のステータスと新しいステータスが同一であれば、更新は行われません。
     * 異なる場合は記事のステータスを更新し、リポジトリに保存します。
     *
     * @param int $articleId 記事を一意に識別するID。
     * @param string $newStatus 記事に設定する新しいステータスの文字列表現。
     *
     * @throws \DomainException 指定された記事が存在しない場合。
     * @throws \InvalidArgumentException 無効なステータスが指定された場合。
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
