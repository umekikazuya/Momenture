<?php

namespace App\UseCases\Article;

use App\Http\Requests\Article\UpdateRequest;
use App\Models\Article;

class UpdateAction
{
    /**
     * 記事データ更新.
     *
     * @param  string        $id
     * @param  UpdateRequest $request
     * @return Article
     */
    public function handle(string $id, UpdateRequest $request): Article
    {
        $article = Article::findOrFail($id);
        $article->fill($request->validated());
        $article->save();

        return $article;
    }
}
