<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
Route::get('/stories/{story}', [StoryController::class, 'show'])->name('stories.show');
Route::resource('posts', PostController::class);
Route::post('posts/{post}/like', [LikeController::class, 'toggle']);
Route::get('/', [HomeController::class, 'index'])->name('home');
