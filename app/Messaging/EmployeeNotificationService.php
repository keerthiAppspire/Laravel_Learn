<?php

namespace App\Messaging;

use App\Models\Employee;

class EmployeeNotificationService
{
    public function __construct(
        private ChannelResolver $resolver,
    ) {
        //
    }

    public function notify(Employee $employee, string $message): DeliveryResult
    {
        $channel = $this->resolver->resolve($employee);

        return $channel->send(
            $employee,
            new OutboundMessage($message),
        );
    }
}