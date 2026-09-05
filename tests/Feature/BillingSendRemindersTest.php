<?php

use App\Models\Invoice;
use App\Notifications\InvoiceReminder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

test('it does not send reminders in dry run mode', function () {
    Notification::fake();

    Invoice::create([
        'customer_name' => 'Acme Corp',
        'amount' => 1000,
        'due_date' => now()->subDays(10)->toDateString(),
        'status' => 'unpaid',
    ]);

    $this->artisan('billing:send-reminders', [
        '--dry-run' => true,
    ])->assertSuccessful();

    Notification::assertNothingSent();
});
test('it sends reminders for overdue invoices', function () {
    Notification::fake();

    $invoice = Invoice::create([
        'customer_name' => 'Acme Corp',
        'amount' => 1000,
        'due_date' => now()->subDays(10)->toDateString(),
        'status' => 'unpaid',
    ]);

    $this->artisan('billing:send-reminders')
        ->assertSuccessful();

    Notification::assertSentTo(
        $invoice,
        InvoiceReminder::class
    );
});
test('it returns failure when sending reminders fails', function () {
    Notification::fake();

    Invoice::create([
        'customer_name' => 'Acme Corp',
        'amount' => 1000,
        'due_date' => now()->subDays(10)->toDateString(),
        'status' => 'unpaid',
    ]);

    Notification::shouldReceive('send')
        ->andThrow(new Exception('Notification failure'));

    $this->artisan('billing:send-reminders')
        ->assertExitCode(1);
});
