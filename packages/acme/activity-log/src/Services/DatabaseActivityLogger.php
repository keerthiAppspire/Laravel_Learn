<?php

namespace Acme\ActivityLog\Services;

use Acme\ActivityLog\ActivityLog;
use Acme\ActivityLog\Contracts\ActivityLogger;

class DatabaseActivityLogger implements ActivityLogger
{
    public function log(string $message): void
    {
        ActivityLog::create([
            'message' => $message,
        ]);
    }
}