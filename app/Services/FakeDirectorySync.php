<?php

namespace App\Services;
use App\Contracts\DirectorySync;
class FakeDirectorySync implements DirectorySync
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function sync(array $employee): void
    {
        $this->employees[]=$employee;
    }
}
