<?php

namespace App\Services;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Container\Attributes\Storage;

class PayrollAuditExport
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        #[Storage('hr-private')]
        private Filesystem $storage
        ){}
    public function export(): void
    {
        $this->storage->put('payroll_audit.txt', 'Payroll audit export');
    }
    
}
