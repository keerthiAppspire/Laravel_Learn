<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RequestCounter;
use App\Services\FixedExchangeRateProvider;
use App\Contracts\ExchangeRateProvider;
use App\Services\EcbExchangeRateProvider;
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
        $this->app->bind(FixedExchangeRateProvider::class,function(){
            return new FixedExchangeRateProvider(
                config('services.exchange_rates')
            );
        });
        $this->app->bind(
            ExchangeRateProvider::class,
            $this->app->environment('production') 
            ? EcbExchangeRateProvider::class 
            :FixedExchangeRateProvider::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
