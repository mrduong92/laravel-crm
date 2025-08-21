<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\HomeController as BackendHomeController;
use App\Http\Controllers\Backend\UserController;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)
        ->middleware([
            'web',
        ])
        ->group(function () {
        Auth::routes();
        Route::get('/', [BackendHomeController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class);
    });
}
