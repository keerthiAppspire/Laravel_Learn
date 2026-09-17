<?php

namespace Acme\ActivityLog;

use Illuminate\Support\ServiceProvider;
use Acme\ActivityLog\Console\PruneActivityLogsCommand;

class ActivityLogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
         $this->mergeConfigFrom(
            __DIR__ . '/../config/activity-log.php',
            'activity-log'
        );
        $this->app->singleton(
            \Acme\ActivityLog\Contracts\ActivityLogger::class,
            \Acme\ActivityLog\Services\DatabaseActivityLogger::class
        );
    }

    public function boot(): void
    {
         $this->publishes([
            __DIR__ . '/../config/activity-log.php' => config_path('activity-log.php'),
        ], 'activity-log-config');
        $this->loadMigrationsFrom(
              __DIR__ . '/../database/migrations'
        );
        $this->app->alias(
            \Acme\ActivityLog\Contracts\ActivityLogger::class,
            'activity-log'
        );
         if ($this->app->runningInConsole()) {
            $this->commands([
                PruneActivityLogsCommand::class,
            ]);
        }
    }
}