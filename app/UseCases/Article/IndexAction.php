<?php

namespace App\UseCases\Article;

use App\Http\Requests\Article\ListRequest;
use App\Models\Article;

class IndexAction
{
    public function handle(ListRequest $request)
    {
        $query = Article::query();
        $filters = $request->filters();
        if (isset($filters['is_pickup'])) {
            $query->where('is_pickup', $filters['is_pickup']);
        }

        return $query->get();
    }
}
