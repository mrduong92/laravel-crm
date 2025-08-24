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
            // Add some items to the menu...
            if (tenant('id') === null) {
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

            if (auth()->guard('owner')->check()) {
                $event->menu->add('CÀI ĐẶT ADMIN');
                $event->menu->add([
                    'text' => 'Quản lý admin',
                    'url' => '/users/admin',
                ]);
            }
        });
    }
}
