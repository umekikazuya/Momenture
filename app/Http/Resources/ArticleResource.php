<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Domain\Entities\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Article リソースを JSON レスポンス用の連想配列に変換します。
     *
     * 渡されたリソースが Article インスタンスでない場合は空の配列を返します。
     * 有効な Article インスタンスの場合、記事の ID、タイトル、リンク、公開状況（公開または下書き）、
     * 関連するサービス情報（ID と名前）、および formatted な作成・更新日時を含む配列に変換します。
     *
     * @return array<string, mixed> 変換された記事情報の連想配列
     */
    public function toArray(Request $request): array
    {
        if (! $this->resource instanceof Article) {
            return [];
        }

        return [
            'id' => $this->resource->id(),
            'title' => $this->resource->title()->value(),
            'link' => $this->resource->link()->value(),
            'status' => $this->resource->isPublished() ? 'published' : 'draft',
            'service' => [
                'id' => $this->resource->service()->id()->value(),
                'name' => $this->resource->service()->name()->value(),
            ],
            'created_at' => $this->resource->createdAt()->format('Y-m-d H:i:s'),
            'updated_at' => $this->resource->updatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
