<?php

namespace App\UseCases\Article;

use App\Http\Requests\Article\DeleteRequest;
use App\Models\Article;

class DeleteAction
{
    /**
     * 記事データ削除.
     */
    public function handle(string $id, DeleteRequest $request): bool
    {
        $article = Article::findOrFail($id);

        return $article->destroy($id);
    }
}
