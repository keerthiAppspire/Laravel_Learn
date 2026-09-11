<?php

namespace App\Contracts;

interface DirectorySync
{
    /** @param array<string, mixed> $employee */
    public function sync(array $employee): void;
}
