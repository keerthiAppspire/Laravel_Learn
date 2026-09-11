<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MessagingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void

    {
        $this->app->bind(
            \App\Messaging\SmtpEmailChannel::class,
            \App\Messaging\SmtpEmailChannel::class
        );

        $this->app->bind(
            \App\Messaging\TwilioSmsChannel::class,
            \App\Messaging\TwilioSmsChannel::class
        );

        $this->app->bind(
            \App\Messaging\LogChannel::class,
            \App\Messaging\LogChannel::class
        );

        if (app()->environment(['local', 'testing'])) {
            $this->app->bind(
                \App\Contracts\MessageChannel::class,
                 \App\Messaging\LogChannel::class
            );
        }
        $this->app 
            ->when(\App\Messaging\TwilioSmsChannel::class) 
            ->needs('$apiKey') 
            ->giveConfig('services.twilio.api_key'); 
    }
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
