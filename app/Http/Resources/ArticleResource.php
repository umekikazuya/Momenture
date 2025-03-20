<?php

namespace App\Http\Resources;

use App\Domain\Entities\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * リソースを連想配列に変換する。
     *
     * このメソッドは、リソースが Article インスタンスの場合、記事の各種情報（ID、タイトル、リンク、公開状態、
     * 関連サービス情報、作成日時、更新日時）を整形した連想配列として返します。リソースが Article でない場合は、
     * 空の配列を返します。
     *
     * @param Request $request HTTPリクエスト
     * @return array<string, mixed> 変換後の記事リソースの連想配列
     */
    public function toArray(Request $request): array
    {
        if (!$this->resource instanceof Article) {
            return [];
        }
        return [
            'id' => $this->resource->id(),
            'title' => $this->resource->title()->value(),
            'link' => $this->resource->link()->value(),
            'status' => $this->isPublished() ? 'published' : 'draft',
            'service' => [
                'id' => $this->service()->id(),
                'name' => $this->service()->name(),
            ],
            'created_at' => $this->createdAt()->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
