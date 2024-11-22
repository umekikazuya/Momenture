<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Welcome to the Momenture API!',
        'version' => '1.0.0',
        'site_url' => 'https://www.umekikazuya.me',
    ]);
});
