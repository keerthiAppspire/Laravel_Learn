<?php

namespace App\Messaging;

use App\Contracts\MessageChannel;
use App\Messaging\SmtpEmailChannel;
use App\Messaging\TwilioSmsChannel;
use App\Messaging\LogChannel;
use App\Models\Employee;
class ChannelResolver
{
    /**
     * Create a new class instance.
     */
    public function __construct( 
        private SmtpEmailChannel $email,
        private TwilioSmsChannel $sms,
        private LogChannel $log,
    )
    {
        //
    }
    public function resolve(Employee $employee): MessageChannel
    {
        return match ($employee->preferred_channel) {
            'email' => $this->email,
            'sms' => $this->sms,
            'log' => $this->log,
            default => $this->log,
        };
    }
}
