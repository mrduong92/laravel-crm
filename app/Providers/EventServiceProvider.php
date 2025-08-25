<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            if (tenant()) {
                if (auth()->user()->role !== 'sales') {
                    $event->menu->add('CÀI ĐẶT USER');
                    $event->menu->add([
                        'text' => 'Quản lý user',
                        'url' => '/users',
                    ]);
                }
            } else {
                $event->menu->add('CÀI ĐẶT USER');
                $event->menu->add([
                    'text' => 'Quản lý user',
                    'url' => '/users',
                ]);
                $event->menu->add([
                    'text' => 'Quản lý tenant',
                    'url' => '/tenants',
                ]);
            }
        });
    }
}
