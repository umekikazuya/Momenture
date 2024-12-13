<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\ListRequest;
use App\Http\Resources\ArticleCollectionResource;
use App\UseCases\Article\IndexAction;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ListRequest $request, IndexAction $action): ArticleCollectionResource
    {
        // 検索条件を取得
        $filters = $request->filters();
        $sort = $request->sort();
        $pagination = $request->pagination();

        // UseCaseを実行して結果を取得
        $articles = $action->handle($filters, $sort, $pagination);

        return new ArticleCollectionResource($articles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
