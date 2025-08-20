<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\HomeController as BackendHomeController;
use App\Http\Controllers\Backend\PostController as BackendPostController;
use App\Http\Controllers\Backend\CategoryController as BackendCategoryController;
use App\Http\Controllers\SuperAdmin\AuthController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::group([
    'middleware' => ['web'],
    'as' => 'frontend.',
], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Auth::routes();
    Route::group([
        'middleware' => ['web'],
        'as' => 'backend.',
    ], function () {
        Route::get('/dashboard', [BackendHomeController::class, 'index'])->name('home');
        Route::resource('posts', BackendPostController::class);
        Route::resource('categories', BackendCategoryController::class);
    });
});

foreach (config('tenancy.central_domains') as $domain) {
    Route::prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('login', [AuthController::class, 'loginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('password/reset', [AuthController::class, 'showResetForm'])->name('password.request');
        Route::post('password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
        Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');

        Route::middleware('guards.superadmin')->group(function () {
            Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        });
    });
}
