<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\ListRequest;
use App\Http\Resources\ArticleResource;
use App\UseCases\Article\IndexAction;
use Illuminate\Http\Request;

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
    public function index(ListRequest $request)
    {
        // UseCaseを実行して結果を取得
        $articles = $this->indexAction->handle($request);

        return new ArticleResource($articles);
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
