<?php

namespace App\Http\Resources;

use App\Domain\Entities\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (! $this->resource instanceof ArticleService) {
            return [];
        }

        return [
            'id' => $this->resource->id()->value(),
            'name' => $this->resource->name()->value(),
        ];
    }
}
