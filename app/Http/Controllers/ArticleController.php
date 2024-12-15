<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\IndexRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Http\Resources\ArticleCollectionResource;
use App\Http\Resources\ArticleResource;
use App\UseCases\Article\IndexAction;
use App\UseCases\Article\ShowAction;
use App\UseCases\Article\StoreAction;
use App\UseCases\Article\UpdateAction;

class ArticleController extends Controller
{
    /**
     * API - 一覧.
     */
    public function index(IndexRequest $request, IndexAction $action)
    {
        $collection = $action->handle($request);

        return new ArticleCollectionResource($collection);
    }

    /**
     * API - 作成.
     */
    public function store(StoreRequest $request, StoreAction $action): ArticleResource
    {
        $article = $action->handle($request);

        return new ArticleResource($article);
    }

    /**
     * API - 取得.
     */
    public function show(string $id, ShowAction $action): ArticleResource
    {
        $article = $action->handle($id);

        return new ArticleResource($article);
    }

    /**
     * API - 更新.
     */
    public function update(UpdateRequest $request, string $id, UpdateAction $action)
    {
        $article = $action->handle($id, $request);

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
