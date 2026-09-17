<?php

namespace Acme\ActivityLog\Facades;

use Illuminate\Support\Facades\Facade;

class ActivityLog extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Acme\ActivityLog\Contracts\ActivityLogger::class;
    }
}
