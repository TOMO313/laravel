<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\MessageController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(PostController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/posts/{post}', 'show')->name('show');
});

Route::get('/map', function () {
    return view('maps.map');
})->middleware('auth')->name('map');

Route::controller(MapController::class)->middleware('auth')->group(function () {
    Route::post('/route', 'getRoute')->name('route');
});

Route::controller(RatingController::class)->middleware('auth')->group(function () {
    Route::post('/rating', 'store');
});

Route::controller(LikeController::class)->middleware('auth')->group(function () {
    Route::post('/posts/like', 'store');
});

Route::controller(ChartController::class)->middleware('auth')->group(function () {
    Route::get('/chart', 'getAmountByYear')->name('chart');
    Route::get('/google', 'getData')->name('google');
});

Route::get('/grid', function () {
    return view('grids.grid');
})->middleware('auth')->name('grid');

Route::controller(MessageController::class)->middleware('auth')->group(function () {
    Route::get('/chat', 'index')->name('chat');
    Route::post('/store', 'store')->name('chat.store');
});

require __DIR__ . '/auth.php';
