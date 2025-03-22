<?php

namespace App\UseCases\Article;

use App\Models\Article;

class ShowAction
{
    /**
     * IDから記事Modelの取得.
     *
     * @param  string $id
     * @return Article
     */
    public function handle(string $id): Article
    {
        return Article::findOrFail($id);
    }
}
