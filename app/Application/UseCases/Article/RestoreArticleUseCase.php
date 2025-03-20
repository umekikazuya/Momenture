<?php

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;

class RestoreArticleUseCase implements RestoreArticleUseCaseInterface
{
    /**
     * コンストラクタ。
     *
     * ArticleRepositoryInterface のインスタンスを受け取り、記事の復元処理に必要なリポジトリとして内部に保持します。
     */
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * 指定された記事IDに対応する削除済み記事を復元します。
     *
     * 指定された記事IDで削除済みの記事を検索し、記事が見つかった場合は復元処理を実行します。
     * 記事が見つからなかった場合は、\DomainException をスローします。
     *
     * @param int $articleId 復元対象の記事のID
     *
     * @throws \DomainException 指定された記事が存在しない場合にスローされます。
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
