<?php

namespace App\Http\Resources;

use App\Domain\Entities\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * 記事リソースを配列形式に変換して返す。
     *
     * リクエストに応じた記事リソースの詳細情報を整形します。
     * リソースが Article のインスタンスでない場合は、空の配列を返します。
     * 有効な記事の場合、記事ID、タイトル、リンク、公開状態（'published' または 'draft'）、
     * 関連サービスのIDおよび名前、作成日時、更新日時を含む連想配列を返します。
     *
     * @return array<string, mixed> 記事の情報を格納した連想配列。非 Article インスタンスの場合は空の配列。
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
