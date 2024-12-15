<?php

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollectionResource extends ResourceCollection
{
    /**
     * {@inheritDoc}
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection->map(function (Article $article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'link' => $article->link,
                    'service' => $article->service,
                    'is_pickup' => $article->is_pickup,
                ];
            }),
            'meta' => [],
        ];
    }
}
