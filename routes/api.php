<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleServiceController;
use App\Http\Controllers\FeedQiitaController;
use App\Http\Controllers\FeedZennController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('articles')->group(function () {
    Route::post('/', [ArticleController::class, 'store']); // 作成
    Route::put('{id}', [ArticleController::class, 'update']); // 更新
    Route::delete('{id}', [ArticleController::class, 'destroy']); // 削除（force対応）
    Route::post('{id}/restore', [ArticleController::class, 'restore']); // 復元
    Route::get('{id}', [ArticleController::class, 'show']); // 詳細取得
    Route::get('/', [ArticleController::class, 'index']); // 一覧・検索
    Route::patch('{id}/status', [ArticleController::class, 'changeStatus']); // 公開状態変更
});
Route::prefix('article-services')->group(function () {
    Route::post('/', [ArticleServiceController::class, 'store']);
    Route::put('{articleService}', [ArticleServiceController::class, 'update']);
    Route::delete('{articleService}', [ArticleServiceController::class, 'destroy']);
    Route::get('{articleService}', [ArticleServiceController::class, 'show']);
    Route::get('/', [ArticleServiceController::class, 'index']);
});
Route::prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'show']);
    Route::post('/', [ProfileController::class, 'store']);
    Route::put('/', [ProfileController::class, 'update']);
    Route::delete('/', [ProfileController::class, 'destroy']);
});
Route::get('qiita/{id}', FeedQiitaController::class);
Route::get('zenn/{id}', FeedZennController::class);
