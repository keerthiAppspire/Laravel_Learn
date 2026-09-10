<?php

namespace App\Services;
use App\Contracts\DirectorySync;
class EmployeeOnboardingService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private DirectorySync $directorySync)
    {
        //
    }
    public function onboard(array $employee): void
    {
        $this->directorySync->sync($employee);
    }
}
