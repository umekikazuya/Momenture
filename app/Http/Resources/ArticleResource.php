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
            'id' => $this->id(),
            'title' => $this->title(),
            'link' => $this->link(),
            'status' => $this->isPublished() ? 'published' : 'draft',
            'service' => [
                'id' => $this->service()->id(),
                'name' => $this->service()->name(),
            ],
            'created_at' => $this->createdAt()->format('Y-m-d H:i:s'),

        ];
    }
}
