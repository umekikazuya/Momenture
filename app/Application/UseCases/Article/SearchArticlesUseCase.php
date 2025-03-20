<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Domain\Repositories\ArticleRepositoryInterface;

class SearchArticlesUseCase implements SearchArticlesUseCaseInterface
{
    /**
     * コンストラクタ。
     *
     * 記事検索機能に必要なリポジトリの依存性を注入します。
     */
    public function __construct(
        private ArticleRepositoryInterface $articleRepository
    ) {
    }

    /**
     * 指定された検索条件に基づき記事を検索し、結果を配列で返します。
     *
     * 各パラメータは検索フィルターとして機能し、指定された場合に該当する記事のみが対象となります。
     *
     * @param string|null $keyword 検索キーワード。記事のタイトルや本文に対する部分一致検索に利用します。
     * @param int|null $serviceId サービスID。特定のサービスに関連する記事の絞り込みに使用します。
     * @param int|null $tagId タグID。特定のタグが付与された記事の検索条件として指定できます。
     *
     * @return array 検索結果として一致した記事の一覧。
     */
    public function execute(?string $keyword = null, ?int $serviceId = null, ?int $tagId = null): array
    {
        return $this->articleRepository->search($keyword, $serviceId, $tagId);
    }
}
