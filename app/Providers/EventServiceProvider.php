<?php

namespace App\Providers;

use App\Listeners\PermissionEventsSubscriber;
use App\Listeners\RoleEventsSubscriber;
use App\Listeners\UserEventsSubscriber;
use App\Listeners\UserWasRegisteredListener;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\User\Registered::class => [UserWasRegisteredListener::class],
    ];


    protected $subscribe = [
        UserEventsSubscriber::class,
        RoleEventsSubscriber::class,
        PermissionEventsSubscriber::class,
    ];


    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
