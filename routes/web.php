<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RatingController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(PostController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/map', function () {
        return view('maps.map');
    })->name('map');
});

Route::controller(RatingController::class)->middleware('auth')->group(function () {
    Route::post('/rating', 'store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
