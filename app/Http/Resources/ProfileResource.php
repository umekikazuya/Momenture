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
        return [
            'id' => $this->resource->id,
            'github' => $this->resource->github,
            'qiita' => $this->resource->qiita,
            'address' => $this->resource->id,
            'zenn' => $this->resource->zenn,
            'skill' => $this->resource->skill,
            'display_name' => $this->resource->display_name,
            'display_short_name' => $this->resource->display_short_name,
            'from' => $this->resource->from,
            'likes' => $this->resource->likes,
            'summary_introduction' => $this->resource->summary_introduction,
            'introduction' => $this->resource->introduction,
            'job' => $this->resource->job,
        ];
    }
}
