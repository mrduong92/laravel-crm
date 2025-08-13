<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Namu\WireChat\Events\MessageCreated;
// use App\Listeners\SendZaloMessage;
use Namu\WireChat\Models\Message;
use App\Observers\MessageObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Message::observe(MessageObserver::class);
        // Event::listen(
        //     MessageCreated::class,
        //     SendZaloMessage::class,
        // );
    }
}
