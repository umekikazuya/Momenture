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
            'address' => $this->resource->address,
            'display_name' => $this->resource->display_name,
            'display_short_name' => $this->resource->display_short_name,
            'from' => $this->resource->from,
            'github' => $this->resource->github,
            'id' => $this->resource->id,
            'introduction' => $this->resource->introduction,
            'job' => $this->resource->job,
            'likes' => $this->resource->likes,
            'qiita' => $this->resource->qiita,
            'skill' => $this->resource->skill,
            'summary_introduction' => $this->resource->summary_introduction,
            'zenn' => $this->resource->zenn,
        ];
    }
}
