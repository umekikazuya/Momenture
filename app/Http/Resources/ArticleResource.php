<?php

namespace App\Http\Resources;

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
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'link' => $this->resource->link,
            'service' => $this->resource->service,
            'is_pickup' => $this->resource->is_pickup,
            'published' => $this->resource->published,
        ];
    }
}
