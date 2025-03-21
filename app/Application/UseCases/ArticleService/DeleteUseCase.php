<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Domain\Repositories\ArticleServiceRepositoryInterface;

class DeleteUseCase implements DeleteUseCaseInterface
{
    /**
     * コンストラクタ
     *
     * 記事削除に必要なリポジトリを注入し、ユースケースインスタンスを初期化します。
     */
    public function __construct(private ArticleServiceRepositoryInterface $articleServiceRepository) {
    }

    /**
     * 指定されたIDの記事サービスを削除する。
     *
     * リポジトリから指定記事サービスを取得し、存在する場合は強制削除または通常削除を実施する。
     * 該当記事サービスが見つからない場合は、DomainExceptionが内部で捕捉され、削除処理は実行されない。
     * 処理中に予期しないエラーが発生した場合は、RuntimeExceptionがスローされる。
     *
     * @param int $id 削除対象の記事サービスの識別子。
     * @param bool $force 強制削除を行う場合はtrue（デフォルトはfalse）。
     *
     * @throws \RuntimeException 削除処理中に予期しないエラーが発生した場合にスローされる。
     */
    public function execute(int $id, bool $force = false): void
    {
        try {
            $article = $this->articleServiceRepository->findById($id);
            if (! $article) {
                throw new \DomainException("ID: {$id} の記事サービスが見つかりません。");
            }
            if ($force) {
                $this->articleServiceRepository->forceDelete($article);
            } else {
                $this->articleServiceRepository->delete($article);
            }
        } catch (\DomainException $e) {
            throw new \RuntimeException("ID: {$id} の記事サービスは存在しません", 0, $e);
        } catch (\Exception $e) {
            throw new \RuntimeException("ID: {$id} の記事サービスの削除中にエラーが発生しました", 0, $e);
        }
    }
}
