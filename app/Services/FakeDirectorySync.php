<?php

namespace App\Services;
use App\Contracts\DirectorySync;
class FakeDirectorySync implements DirectorySync
{
    /** @var array<int, array<string, mixed>> */
    public array $employees = [];
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
     /** @param array<string, mixed> $employee */
    public function sync(array $employee): void
    {
        $this->employees[]=$employee;
    }
      /** @return array<int, array<string, mixed>> */
    public function getEmployees(): array
    {
        return $this->employees;
    }
}
