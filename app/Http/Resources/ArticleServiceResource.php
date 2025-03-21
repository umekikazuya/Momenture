<?php

namespace App\Http\Resources;

use App\Domain\Entities\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleServiceResource extends JsonResource
{
    /**
     * リソースを連想配列に変換する。
     *
     * リソースが ArticleService のインスタンスの場合は、その id および name を抽出し、
     * 'id' および 'name' キーを持つ配列として返します。
     * それ以外の場合は、空の配列を返します。
     *
     * @return array<string, mixed> ArticleService の情報を表す連想配列
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
