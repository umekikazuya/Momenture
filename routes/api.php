<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FeedQiitaController;
use App\Http\Controllers\FeedZennController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('profile', ProfileController::class)->only(['show', 'update']);

Route::apiResource('article', ArticleController::class);

Route::get('qiita/{id}', FeedQiitaController::class);
Route::get('zenn/{id}', FeedZennController::class);
