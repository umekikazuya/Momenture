<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FeedQiitaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('profile', ProfileController::class);

Route::apiResource('article', ArticleController::class)->only(['show', 'store']);

Route::get('qiita/{id}', FeedQiitaController::class);
