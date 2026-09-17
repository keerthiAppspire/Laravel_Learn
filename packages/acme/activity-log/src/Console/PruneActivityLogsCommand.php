<?php

namespace Acme\ActivityLog\Console;

use Acme\ActivityLog\ActivityLog;
use Illuminate\Console\Command;

class PruneActivityLogsCommand extends Command
{
    protected $signature = 'activity-log:prune {--days=90}';

    protected $description = 'Prune old activity logs';

    public function handle(): int
    {
        $days = (int) $this->option('days');

        $deleted = ActivityLog::where(
            'created_at',
            '<',
            now()->subDays($days)
        )->delete();

        $this->info("Deleted {$deleted} old activity logs.");

        return self::SUCCESS;
    }
}