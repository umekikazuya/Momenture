<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;
use DomainException;

class DeleteArticleUseCase implements DeleteArticleUseCaseInterface
{
    /**
     * コンストラクタ
     *
     * DeleteArticleUseCase を初期化し、記事リポジトリの依存性を注入します。
     */
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * 指定された記事を削除する。
     *
     * 指定された記事IDで記事を検索し、記事が存在しない場合にはDomainExceptionをスローします。
     * forceフラグがtrueの場合は強制削除を、falseの場合は通常のソフトデリートを実行します。
     *
     * @param int $id 記事ID
     * @param bool $force trueの場合は強制削除、falseの場合は通常の削除を行う
     *
     * @throws DomainException 指定されたIDの記事が存在しない場合
     */
    public function execute(int $id, bool $force = false): void
    {
        $article = $this->articleRepository->findById($id);

        if (! $article) {
            throw new DomainException("ID: {$id} の記事が見つかりません。");
        }

        if ($force) {
            $this->articleRepository->forceDelete($article);
        } else {
            $this->articleRepository->delete($article);
        }
    }
}
