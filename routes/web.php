<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\HomeController as BackendHomeController;
use App\Http\Controllers\Backend\PostController as BackendPostController;
use App\Http\Controllers\Backend\CategoryController as BackendCategoryController;

Route::group([
    // 'domain' => parse_url(config('app.url'), PHP_URL_HOST),
    'middleware' => ['web'],
    'as' => 'frontend.',
], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

Auth::routes();

Route::middleware('tenant')->group(function () {
    Route::group([
        // 'domain' => parse_url(config('app.url'), PHP_URL_HOST),
        'middleware' => ['web'],
        'as' => 'backend.',
        'prefix' => 'admin',
    ], function () {
        Route::get('/', [BackendHomeController::class, 'index'])->name('home');
        Route::resource('posts', BackendPostController::class);
        Route::resource('categories', BackendCategoryController::class);
    });
});
