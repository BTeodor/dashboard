<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\User\UserRepository',
            'App\Repositories\User\EloquentUser'
        );

        $this->app->bind(
            'App\Repositories\Role\RoleRepository',
            'App\Repositories\Role\EloquentRole'
        );

        $this->app->bind(
            'App\Repositories\Permission\PermissionRepository',
            'App\Repositories\Permission\EloquentPermission'
        );

        $this->app->bind(
            'App\Repositories\Activity\ActivityRepository',
            'App\Repositories\Activity\EloquentActivity'
        );


    }
}
