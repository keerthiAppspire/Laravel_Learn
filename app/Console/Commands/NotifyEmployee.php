<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Employee;
use App\Messaging\ChannelResolver;
use App\Messaging\OutboundMessage;

#[Signature('notify:employee {id} {message}')]
#[Description('Command description')]
class NotifyEmployee extends Command
{
    /**
     * Execute the console command.
     */
    public function __construct(
    ){
        parent::__construct();
    }
    public function handle(): int
    {
       $resolver = app(ChannelResolver::class);
       $id = $this->argument('id');
       $message = $this->argument('message');
       $employee=Employee::findOrFail($id);
       $channel=$resolver->resolve($employee);
       $outboundMessage = new OutboundMessage($message);
       $result = $channel->send($employee, $outboundMessage);
       $this->info($result->successful ? 'Message sent successfully.' : 'Message failed.');
       return $result->successful ? self::SUCCESS : self::FAILURE;
    }
}
