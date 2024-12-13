<?php

namespace App\UseCases\Article;

use App\Models\Article;

class IndexAction
{
    public function handle(array $filters, array $sort, array $pagination)
    {
        $query = Article::query();

        // ソートの適用
        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        // ページネーションの適用
        return $query->paginate(
            $pagination['per_page'],
            ['*'],
            'page',
            $pagination['page']
        );
    }
}
