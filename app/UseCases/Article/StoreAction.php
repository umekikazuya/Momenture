<?php

namespace App\UseCases\Article;

use App\Http\Requests\Article\StoreRequest;
use App\Models\Article;

class StoreAction
{
    /**
     * 記事データ作成.
     *
     * @param StoreRequest $request
     * @return Article
     */
    public function handle(StoreRequest $request): Article
    {
        $article = $this->create($request->validated());
        $article->save();

        return $article;
    }

    /**
     * オブジェクト生成.
     */
    private function create(array $data): Article
    {
        return new Article($data);
    }
}
