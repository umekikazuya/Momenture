<?php

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;

class RestoreArticleUseCase implements RestoreArticleUseCaseInterface
{
    /**
     * コンストラクタ
     *
     * 記事復元操作に必要な記事リポジトリの依存性を注入して、インスタンスを初期化します。
     */
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * 指定されたIDの削除済み記事を復元する。
     *
     * 指定された記事IDに基づいて削除済みの記事を検索し、該当記事が存在しない場合はDomainExceptionをスローします。
     * 該当記事が見つかった場合、記事の復元を実行します。
     *
     * @param int $articleId 復元対象の削除済み記事のID
     * @throws \DomainException 指定されたIDの削除済み記事が存在しない場合にスローされます
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
