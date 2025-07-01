<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\HomeController as BackendHomeController;
use App\Http\Controllers\Backend\PostController as BackendPostController;

Route::group([
    'domain' => parse_url(config('app.url'), PHP_URL_HOST),
    'middleware' => ['web'],
    'as' => 'frontend.',
], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

Auth::routes();

Route::group([
    'domain' => parse_url(config('app.url'), PHP_URL_HOST),
    'middleware' => ['web'],
    'as' => 'backend.',
    'prefix' => 'backend',
], function () {
    Route::get('/', [BackendHomeController::class, 'index'])->name('home');
    Route::get('/posts', [BackendPostController::class, 'index'])->name('posts.index');
});
