<?php

use App\Messaging\ChannelResolver;
use App\Messaging\SmtpEmailChannel;
use App\Messaging\TwilioSmsChannel;
use App\Messaging\LogChannel;
use App\Models\Employee;
uses(Tests\TestCase::class);
test('resolves the email channel', function () {
    $employee = new Employee([
        'preferred_channel' => 'email',
    ]);

    $resolver = app(ChannelResolver::class);

    $channel = $resolver->resolve($employee);

    expect($channel)->toBeInstanceOf(SmtpEmailChannel::class);
});
test('resolves the sms channel', function () {
    $employee = new Employee([
        'preferred_channel' => 'sms',
    ]);

    $resolver = app(ChannelResolver::class);

    $channel = $resolver->resolve($employee);

    expect($channel)->toBeInstanceOf(TwilioSmsChannel::class);
});
test('resolves the log channel', function () {
    $employee = new Employee([
        'preferred_channel' => 'log',
    ]);

    $resolver = app(ChannelResolver::class);

    $channel = $resolver->resolve($employee);

    expect($channel)->toBeInstanceOf(LogChannel::class);
});