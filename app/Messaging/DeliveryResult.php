<?php

namespace App\Messaging;

class DeliveryResult
{
    /**
     * Create a new class instance.
     */
    public function __construct(public bool $successful)
    {
        //
    }
}
