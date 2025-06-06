<?php

namespace App\Providers;

use App\Repositories\Eloquent\CrudBase\CrudBaseRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        //Observers
        \App\Models\Reservation::observe(\App\Observers\Reservation\ReservationObserver::class);
        //Services
        $this->app->singleton(\App\Services\Auth\AuthService::class,
        \App\Services\Auth\AuthService::class);
        $this->app->singleton(\App\Services\Media\MediaService::class,
        \App\Services\Media\MediaService::class);
        $this->app->singleton(\App\Services\Reservation\ReservationService::class,
        \App\Services\Reservation\ReservationService::class);

        //Repositories
        $this->app->bind(\App\Repositories\Contracts\CrudBase\CrudBaseRepositoryInterface::class,
        \App\Repositories\Eloquent\CrudBase\CrudBaseRepository::class);
        $this->app->bind(\App\Repositories\Contracts\Media\MediaRepositoryInterface::class,
        \App\Repositories\Eloquent\Media\MediaRepository::class);
        $this->app->bind(\App\Repositories\Contracts\Reservation\ReservationRepositoryInterface::class,
        \App\Repositories\Eloquent\Reservation\ReservationRepository::class);
    }
}
