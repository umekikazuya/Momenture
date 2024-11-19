<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'show']);
    Route::post('/', [ProfileController::class, 'store']);
    Route::put('/', [ProfileController::class, 'update']);
    Route::delete('/', [ProfileController::class, 'destroy']);
});
