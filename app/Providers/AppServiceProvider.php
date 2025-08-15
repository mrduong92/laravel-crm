<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Namu\WireChat\Events\MessageCreated;
// use App\Listeners\SendZaloMessage;
use Namu\WireChat\Models\Message;
use App\Livewire\Chat\Chat;
use App\Livewire\Chats\Chats;
use App\Observers\MessageObserver;
use Livewire\Livewire;

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
        Livewire::component('wirechat.chats', Chats::class);
        Livewire::component('wirechat.chat', Chat::class);
        Message::observe(MessageObserver::class);
        // Event::listen(
        //     MessageCreated::class,
        //     SendZaloMessage::class,
        // );
    }
}
