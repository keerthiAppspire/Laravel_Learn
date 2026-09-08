<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RequestCounter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('counter.bind',RequestCounter::class);
        $this->app->singleton('counter.singleton',RequestCounter::class);
        $this->app->scoped('counter.scoped',RequestCounter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
