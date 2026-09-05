<?php

use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

test('it closes invoices for a month', function () {
    Invoice::create([
        'customer_name' => 'Acme Corp',
        'amount' => 1000,
        'due_date' => '2026-05-15',
        'status' => 'unpaid',
    ]);

    $this->artisan('billing:close-month', [
        'period' => '2026-05',
    ])->assertSuccessful();

    expect(Invoice::first()->status)->toBe('closed');
});
test('it returns failure when closing the month fails', function () {
    DB::shouldReceive('transaction')
        ->once()
        ->andThrow(new Exception('Database failure'));

    $this->artisan('billing:close-month', [
        'period' => '2026-05',
    ])->assertExitCode(1);
});
