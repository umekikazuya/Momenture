<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;
use DomainException;

class DeleteArticleUseCase implements DeleteArticleUseCaseInterface
{
    /**
     * DeleteArticleUseCase インスタンスを初期化する。
     *
     * このコンストラクタは記事の取得や削除操作に必要なリポジトリを注入します。
     */
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * 指定されたIDの記事を削除します。
     *
     * 指定したIDの記事が存在しない場合、DomainExceptionをスローします。強制削除フラグがtrueの場合は、永続的に記事を削除し、falseの場合は通常の削除処理を実施します。
     *
     * @param int $id 削除対象の記事のID
     * @param bool $force trueの場合、強制削除を行います。falseの場合は通常の削除を行います。
     *
     * @throws DomainException 指定されたIDの記事が存在しない場合にスローされます。
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
