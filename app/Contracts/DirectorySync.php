<?php

namespace App\Contracts;

interface DirectorySync
{
    public function sync(array $employee): void;
}
