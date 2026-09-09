<?php

namespace App\Services;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Container\Attributes\Storage;
class HeadcountExport
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        #[storage('exports')]
        private Filesystem $storage
    ){}
    public function export(): void
    {
        $this->storage->put('headcount.txt', 'Headcount export');
    }
}
