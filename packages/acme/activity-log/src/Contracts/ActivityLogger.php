<?php

namespace Acme\ActivityLog\Contracts;

interface ActivityLogger
{
    public function log(string $message): void;
}