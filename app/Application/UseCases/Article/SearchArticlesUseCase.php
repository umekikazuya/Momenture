<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;

class SearchArticlesUseCase implements SearchArticlesUseCaseInterface
{
    /**
     * コンストラクタ。
     *
     * ArticleRepositoryInterface の実装を受け取り、記事検索処理に必要なリポジトリを初期化します。
     */
    public function __construct(
        private ArticleRepositoryInterface $articleRepository
    ) {
    }

    /**
     * 指定された検索条件に基づき記事を検索する。
     *
     * このメソッドは、オプションのキーワード、サービスID、およびタグIDを使用して記事をフィルタリングし、
     * 該当する記事の配列を返します。
     *
     * @param string|null $keyword   検索キーワード（オプション）。
     * @param int|null    $serviceId サービスID（オプション）。
     * @param int|null    $tagId     タグID（オプション）。
     *
     * @return array 検索条件に一致する記事の配列。
     */
    public function execute(?string $keyword = null, ?int $serviceId = null, ?int $tagId = null): array
    {
        return $this->articleRepository->search($keyword, $serviceId, $tagId);
    }
}
