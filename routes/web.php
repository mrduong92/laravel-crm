<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\HomeController as BackendHomeController;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)
        ->middleware([
            'web',
        ])
        ->group(function () {
        Auth::routes();
        Route::get('dashboard', [BackendHomeController::class, 'index'])->name('dashboard');
    });
}
