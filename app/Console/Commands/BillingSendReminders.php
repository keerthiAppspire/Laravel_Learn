<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Notifications\InvoiceReminder;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('billing:send-reminders {--dry-run}')]
#[Description('Send reminders for overdue invoices')]
class BillingSendReminders extends Command
{
    public function handle()
    {
        $graceDays = config('billing.grace_days');

        $overdueDate = now()->subDays($graceDays);

        $invoices = Invoice::where('status', 'unpaid')
            ->whereDate('due_date', '<', $overdueDate)
            ->get();

        $this->table(
            ['Invoice', 'Customer', 'Amount', 'Due Date'],
            $invoices->map(fn ($invoice) => [
                $invoice->id,
                $invoice->customer_name,
                $invoice->amount,
                $invoice->due_date->format('Y-m-d'),
            ])->toArray()
        );

        $this->info('Overdue invoices: '.$invoices->count());

        if ($this->option('dry-run')) {
            $this->info('Dry run mode');

            foreach ($invoices as $invoice) {
                $this->line(
                    'Invoice #'.$invoice->id.' would receive a reminder.'
                );
            }
        } else {
            try {
                foreach ($invoices as $invoice) {
                    $invoice->notify(new InvoiceReminder($invoice));
                }
            } catch (\Throwable $e) {
                $this->error('Failed to send reminders.');

                return self::FAILURE;
            }
        }

        return self::SUCCESS;
    }
}
