<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;
use DomainException;

class DeleteArticleUseCase implements DeleteArticleUseCaseInterface
{
    /**
     * コンストラクタ。
     *
     * ArticleRepositoryInterface のインスタンスを注入し、記事操作に必要なリポジトリを初期化します。
     */
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * 指定された記事IDに対応する記事を削除する。
     *
     * リポジトリから記事を取得し、存在しない場合はDomainExceptionをスローします。記事が存在する場合、$forceフラグに応じて通常削除または強制削除を実行します。
     *
     * @param int $id 削除対象の記事のID。
     * @param bool $force trueの場合は強制削除を、falseの場合は通常削除を行います。
     *
     * @throws DomainException 指定されたIDの記事が見つからない場合にスローされます。
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
