<?php

namespace App\Messaging;

use App\Contracts\MessageChannel;
use App\Models\Employee;
use App\Messaging\OutboundMessage;
use App\Messaging\DeliveryResult;

class TwilioSmsChannel implements MessageChannel
{
    /**
     * Create a new class instance.
     */
    public function __construct(private \Illuminate\Http\Client\Factory $http,private string $apiKey,)
    {
        //
    }
    public function send(Employee $to, OutboundMessage $message): DeliveryResult
    {
        $this->http->withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
    ]);

    return new DeliveryResult(true);
    }
}
