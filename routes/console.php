<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Schedule::command('invoices:overdue-report')
    ->dailyAt('06:00')
    ->onOneServer()
    ->withoutOverlapping()
    ->emailOutputOnFailure('your-email@example.com');
Schedule::command('billing:close-month '.now()->subMonth()->format('Y-m'))
    ->monthly()
    ->withoutOverlapping();
Schedule::command('billing:send-reminders')
    ->dailyAt('09:00')
    ->withoutOverlapping();
