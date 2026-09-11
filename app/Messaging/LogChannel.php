<?php

namespace App\Messaging;

use App\Contracts\MessageChannel;
use App\Models\Employee;
use App\Messaging\OutboundMessage;
use App\Messaging\DeliveryResult;
class LogChannel implements MessageChannel
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function send(Employee $to, OutboundMessage $message): DeliveryResult{
        return new DeliveryResult(true);
    }
}
