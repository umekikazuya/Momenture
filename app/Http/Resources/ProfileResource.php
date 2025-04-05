<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (! $this->resource instanceof \App\Domain\Entities\Profile) {
            return [];
        }
        return [
            'id' => $this->resource->id()->value(),
            'address' => $this->resource->address()->value(),
            'display_name' => $this->resource->displayName()->value(),
            'display_short_name' => $this->resource->displayShortName()->value(),
            'from' => $this->resource->from()->value(),
            'github' => $this->resource->github()->value(),
            'introduction' => $this->resource->introduction()->value(),
            'job' => $this->resource->job()->value(),
            'likes' => $this->resource->likes()->toCollection(),
            'qiita' => $this->resource->qiita()->value(),
            'skills' => $this->resource->skills()->toCollection(),
            'summary_introduction' => $this->resource->summaryIntroduction()->value(),
            'zenn' => $this->resource->zenn()->value(),
        ];
    }
}
