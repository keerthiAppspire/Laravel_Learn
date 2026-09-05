<?php

namespace Tests\Feature;

use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OverdueInvoiceReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_overdue_invoice_report_runs_successfully(): void
    {
        Invoice::create([
            'customer_name' => 'ABC Company',
            'amount' => 1500,
            'due_date' => now()->subDays(40),
            'status' => 'unpaid',
        ]);

        $this->artisan('invoices:overdue-report')
            ->assertExitCode(0);
    }

    public function test_overdue_invoice_report_fails_for_invoice_over_90_days(): void
    {
        Invoice::create([
            'customer_name' => 'Old Company',
            'amount' => 3000,
            'due_date' => now()->subDays(100),
            'status' => 'unpaid',
        ]);

        $this->artisan('invoices:overdue-report')
            ->assertExitCode(1);
    }
}
