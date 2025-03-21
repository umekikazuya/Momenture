<?php

namespace App\Http\Resources;

use App\Domain\Entities\FeaturedArticle;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeaturedArticleResource extends JsonResource
{
    /**
     * リソースを連想配列に変換する。
     *
     * リソースが FeaturedArticle のインスタンスの場合は、その id および name を抽出し、
     * 'id' および 'name' キーを持つ配列として返します。
     * それ以外の場合は、空の配列を返します。
     *
     * @return array<string, mixed> FeaturedArticle の情報を表す連想配列
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
                'link' => $this->resource->article()->link()->value(),
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
