<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Backend\HomeController as HomeController;
use Namu\WireChat\Livewire\Pages\Chat;
use Namu\WireChat\Livewire\Pages\Chats;
use Livewire\Mechanisms\HandleRequests\HandleRequests;
use Livewire\Mechanisms\FrontendAssets\FrontendAssets;
use Livewire\Features\SupportFileUploads\FilePreviewController;
use Livewire\Features\SupportFileUploads\FileUploadController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Tenant\UserController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/


Broadcast::routes([
    'middleware' => ['web', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class],
]);

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    ])->group(function () {
    // Auth routes for web
    Auth::routes();

    Route::middleware('auth')->group(function () {
        Route::get('password/change', [ChangePasswordController::class, 'displayChangePasswordForm'])->name('password.change');
        Route::get('profile', function () {
            return redirect()->route('users.edit', ['user' => Auth::id()]);
        })->name('users.profile');
        Route::put('password/change', [ChangePasswordController::class, 'changePassword'])->name('password.update');

        Route::resource('users', UserController::class);

        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::middleware(config('wirechat.routes.middleware'))
            ->prefix(config('wirechat.routes.prefix'))
            ->group(function () {
            Route::get('/', Chats::class)->name('chats');
            Route::get('/{conversation}', Chat::class)->middleware('belongsToConversation')->name('chat');
        });
    });
    // Livewire routes
    Route::get('livewire/livewire.js', [FrontendAssets::class, 'returnJavaScriptAsFile']);
    Route::get('livewire/livewire.min.js.map', [FrontendAssets::class, 'maps']);
    Route::get('livewire/preview-file/{filename}', [FilePreviewController::class, 'handle'])->name('livewire.preview-file');
    Route::post('livewire/update', [HandleRequests::class, 'handleUpdate'])->name('livewire.update');
    Route::post('livewire/upload-file', [FileUploadController::class, 'handle'])->name('livewire.upload-file');
});
