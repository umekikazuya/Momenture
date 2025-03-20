<?php

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;

class RestoreArticleUseCase implements RestoreArticleUseCaseInterface
{
    /**
     * コンストラクタ
     *
     * 記事リポジトリのインスタンスを受け取り、削除済み記事の復元操作に必要な依存性を初期化します。
     */
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * 指定された記事IDに対応する削除済みの記事を復元します。
     *
     * 記事リポジトリから削除済みの記事を検索し、見つかった場合は復元処理を実行します。
     * 指定されたIDに対応する削除済みの記事が存在しない場合は、DomainException を発生させます。
     *
     * @param int $articleId 復元対象の記事ID
     *
     * @throws \DomainException 指定されたIDの削除済み記事が存在しない場合
     */
    public function execute(int $articleId): void
    {
        $article = $this->articleRepository->findTrashedById($articleId);

        if (!$article) {
            throw new \DomainException("削除済みの記事が見つかりません。");
        }

        $this->articleRepository->restore($article);
    }
}
