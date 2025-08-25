<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\HomeController as BackendHomeController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\TenantController;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)
        ->middleware([
            'web',
        ])
        ->group(function () {
        Auth::routes();
        Route::get('/', [BackendHomeController::class, 'index'])->name('home');
        Route::get('auth/password', [AuthController::class, 'displayChangePasswordForm'])->name('users.password');
        Route::get('auth/profile', function () {
            return redirect()->route('users.edit', ['user' => Auth::id()]);
        })->name('users.profile');
        Route::put('auth/password', [AuthController::class, 'changePassword'])->name('users.change-password');
        Route::resource('users', UserController::class);
        Route::resource('tenants', TenantController::class);
        // User
    });
}
