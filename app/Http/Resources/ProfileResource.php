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
            'address' => $this->resource->address,
            'zenn' => $this->resource->zenn,
            'skill' => $this->resource->skill,
            'displayName' => $this->resource->display_name,
            'displayShortName' => $this->resource->display_short_name,
            'from' => $this->resource->from,
            'likes' => $this->resource->likes,
            'summaryIntroduction' => $this->resource->summary_introduction,
            'introduction' => $this->resource->introduction,
            'job' => $this->resource->job,
        ];
    }
}
