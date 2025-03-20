<?php

namespace App\Http\Resources;

use App\Domain\Entities\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
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
