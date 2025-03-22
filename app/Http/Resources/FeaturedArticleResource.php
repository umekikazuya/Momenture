<?php

namespace App\Http\Resources;

use App\Domain\Entities\FeaturedArticle;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeaturedArticleResource extends JsonResource
{
    /**
     * リソースから FeaturedArticle の情報を連想配列に変換します。
     *
     * リソースが FeaturedArticle のインスタンスの場合、返却される配列には以下の情報が含まれます:
     * - 'id': FeaturedArticle の識別子
     * - 'article': 関連する記事の詳細情報を含む連想配列
     *   - 'id': 記事の識別子
     *   - 'title': 記事のタイトル
     *   - 'link': 記事のリンク
     *   - 'status': 記事の公開状態（'published' または 'draft'）
     *   - 'service': 記事に関連するサービス情報を含む連想配列
     *     - 'id': サービスの識別子
     *     - 'name': サービス名
     *   - 'created_at': 記事の作成日時（'Y-m-d H:i:s' フォーマット）
     *   - 'updated_at': 記事の最終更新日時（'Y-m-d H:i:s' フォーマット）
     * - 'priority': FeaturedArticle の優先度
     * - 'is_active': FeaturedArticle のアクティブ状態
     *
     * リソースが FeaturedArticle のインスタンスでない場合は、空の配列を返します。
     *
     * @return array<string, mixed> 変換された FeaturedArticle の情報を含む連想配列
     */
    public function toArray(Request $request): array
    {
        if (! $this->resource instanceof FeaturedArticle) {
            return [];
        }

        return [
            'id' => $this->resource->id()->value(),
            'article' => [
                'id' => $this->resource->article()->id(),
                'title' => $this->resource->article()->title()->value(),
                'link' => $this->resource->article()->hasLink()
                ? $this->resource->article()->link()->value()
                : null,
                'status' => $this->resource->article()->isPublished() ? 'published' : 'draft',
                'service' => [
                    'id' => $this->resource->article()->service()->id()->value(),
                    'name' => $this->resource->article()->service()->name()->value(),
                ],
                'created_at' => $this->resource->article()->createdAt()->format('Y-m-d H:i:s'),
                'updated_at' => $this->resource->article()->updatedAt()->format('Y-m-d H:i:s'),
            ],
            'priority' => $this->resource->priority()->value(),
            'is_active' => $this->resource->isActive(),
        ];
    }
}
