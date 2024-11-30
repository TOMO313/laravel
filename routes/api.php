<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/posts', [PostController::class, 'apiIndex'])->middleware('throttle:5,1'); //middleware('throttle:5,1')で1分間に5回以上のリクエストまで許可(web.phpでも使用可)