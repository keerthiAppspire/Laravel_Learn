<?php

use Acme\ActivityLog\ActivityLogServiceProvider;
use Acme\ActivityLog\Contracts\ActivityLogger;
use Acme\ActivityLog\Services\DatabaseActivityLogger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->app->register(ActivityLogServiceProvider::class);
});

it('registers the activity logger binding', function () {
    $logger = app(ActivityLogger::class);

    expect($logger)->toBeInstanceOf(DatabaseActivityLogger::class);
});
it('publishes the activity log config', function () {
    $this->artisan('vendor:publish', [
        '--tag' => 'activity-log-config',
        '--force' => true,
    ])->assertExitCode(0);

    expect(file_exists(config_path('activity-log.php')))->toBeTrue();
});
it('prunes only activity logs older than the requested days', function () {
    $oldLog = \Acme\ActivityLog\ActivityLog::create([
        'message' => 'Old log',
    ]);

    $oldLog->created_at = now()->subDays(100);
    $oldLog->updated_at = now()->subDays(100);
    $oldLog->save();

    $newLog = \Acme\ActivityLog\ActivityLog::create([
        'message' => 'New log',
    ]);

    $this->artisan('activity-log:prune')
        ->assertExitCode(0);

    expect(
        \Acme\ActivityLog\ActivityLog::find($oldLog->id)
    )->toBeNull();

    expect(
        \Acme\ActivityLog\ActivityLog::find($newLog->id)
    )->not->toBeNull();
});