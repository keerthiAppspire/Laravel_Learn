<?php

use App\Models\Employee;
use App\Messaging\LogChannel;
use App\Messaging\DeliveryResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);
test('notifies an employee using their preferred channel', function () {
    $fakeChannel = Mockery::mock(LogChannel::class);
    $fakeChannel
        ->shouldReceive('send')
        ->once()
        ->andReturn(new DeliveryResult(true));
    $this->swap(LogChannel::class, $fakeChannel);
    $employee = Employee::create([
        'preferred_channel' => 'log',
    ]);

    $this->artisan('notify:employee', [
        'id' => $employee->id,
        'message' => 'Welcome',
    ])->assertSuccessful();
});