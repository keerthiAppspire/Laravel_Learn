<?php

namespace App\Services;
use App\Contracts\DirectorySync;
class AzureDirectorySync implements DirectorySync
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    }

    /** @param array<string, mixed> $employee */
    public function sync(array $employee): void
    {
        // Implement the sync logic here
    }
}
