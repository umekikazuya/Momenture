<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\IndexRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Http\Resources\ArticleCollectionResource;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\UseCases\Article\IndexAction;

class ArticleController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct(
        private IndexAction $indexAction,
    ) {
        $this->indexAction = $indexAction;
    }

    /**
     * API - 一覧.
     */
    public function index(IndexRequest $request)
    {
        // UseCaseを実行して結果を取得
        $collection = $this->indexAction->handle($request);

        return new ArticleCollectionResource($collection);
    }

    /**
     * API - 作成.
     */
    public function store(StoreRequest $request): ArticleResource
    {
        // 認可 + フォーマットバリデーション.
        $article = $request->makeArticle();

        $article->save();

        return new ArticleResource($article);
    }

    /**
     * API - 取得.
     */
    public function show(string $id): ArticleResource
    {
        $article = Article::findOrFail($id);

        return new ArticleResource($article);
    }

    /**
     * API - 更新.
     */
    public function update(UpdateRequest $request, string $id)
    {
        // FormRequestからArticleを取得
        $article = $request->findArticle($id);

        // 更新を適用
        $request->fillArticle($article);
        $article->save();

        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
