<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FeedQiitaController;
use App\Http\Controllers\FeedZennController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::apiResource('article', ArticleController::class);
Route::prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'show']);
    Route::post('/', [ProfileController::class, 'store']);
    Route::put('/', [ProfileController::class, 'update']);
    Route::delete('/', [ProfileController::class, 'destroy']);
});
Route::get('qiita/{id}', FeedQiitaController::class);
Route::get('zenn/{id}', FeedZennController::class);
