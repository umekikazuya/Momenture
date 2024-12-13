<?php

namespace App\UseCases\Article;

use App\Http\Requests\Article\ListRequest;
use App\Models\Article;

class IndexAction
{
    public function handle(ListRequest $request)
    {
        // 検索処理を実行
        return Article::query()->get();
    }
}
