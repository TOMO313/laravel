<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\LikeController;

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

Route::controller(RatingController::class)->middleware('auth')->group(function () {
    Route::post('/rating', 'store');
});

Route::controller(LikeController::class)->middleware('auth')->group(function () {
    Route::post('/posts/like', 'store');
});

Route::get('/chart', function(){
    return view('charts.chart');
})->middleware('auth')->name('chart');

require __DIR__ . '/auth.php';
