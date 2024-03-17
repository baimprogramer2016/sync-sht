<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Repositories\Synchronize\SynchronizeInterface::class, \App\Repositories\Synchronize\SynchronizeRepository::class);
        $this->app->bind(\App\Repositories\SynchronizeProcess\SynchronizeProcessInterface::class, \App\Repositories\SynchronizeProcess\SynchronizeProcessRepository::class);
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        // Paginator::defaultView('pagination::bootstrap-4');

    }
}
