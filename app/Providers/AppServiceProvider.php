<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        //Services
        $this->app->singleton(\App\Services\Auth\AuthService::class,
        \App\Services\Auth\AuthService::class);
        $this->app->singleton(\App\Services\Media\MediaService::class,
        \App\Services\Media\MediaService::class);

        //Repositories
        $this->app->bind(\App\Repositories\Contracts\CrudBase\CrudBaseRepositoryInterface::class,
        \App\Repositories\Eloquent\CrudBase\CrudBaseRepository::class);
        $this->app->bind(\App\Repositories\Contracts\Media\MediaRepositoryInterface::class,
        \App\Repositories\Eloquent\Media\MediaRepository::class);
    }
}
