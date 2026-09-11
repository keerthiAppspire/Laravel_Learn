<?php

namespace App\Messaging;

class OutboundMessage
{
    /**
     * Create a new class instance.
     */
    public function __construct(public string $body)
    {
        //
    }
}
