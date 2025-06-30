<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;

Auth::routes();

Route::group([
    'domain' => config('app.url'),
    'middleware' => ['web'],
    'as' => 'frontend.',
], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});
