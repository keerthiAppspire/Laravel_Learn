<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Invoice;
use Illuminate\Support\Facades\File;

#[Signature('invoices:overdue-report {--days=30} {--format=table}')]
#[Description('Generate a report of overdue invoices')]
class OverdueInvoiceReport extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(){
        $days = $this->option('days');
        $invoices = Invoice::where('due_date', '<', today()->subDays($days))
            ->where('status', 'unpaid')
            ->get();
        $this->info('Overdue invoices: ' . $invoices->count());
        $bar = $this->output->createProgressBar($invoices->count());
         if ($this->option('format') === 'csv') {
            File::ensureDirectoryExists(storage_path('app/reports'));
            $file = storage_path('app/reports/overdue-invoices.csv');
            $handle = fopen($file, 'w');
            fputcsv($handle, [
                'Customer',
                'Amount',
                'Due Date',
                'Status',
            ]);
        }
        foreach ($invoices as $invoice) {
            $this->line(
                $invoice->customer_name . ' - ' . $invoice->amount
           );
           $bar->advance();
           if ($this->option('format') === 'csv') {
                fputcsv($handle, [
                    $invoice->customer_name,
                    $invoice->amount,
                    $invoice->due_date,
                    $invoice->status,
             ]);
            }
       }
        $bar->finish(); 
        if ($this->option('format') === 'csv') {
           fclose($handle);
        }
        $hasVeryOldInvoice = $invoices->contains(function ($invoice) {
            return $invoice->due_date->lt(today()->subDays(90));
        });
        if ($hasVeryOldInvoice) {
            $this->error('An invoice is more than 90 days overdue.');
            return self::FAILURE;
        }
        return self::SUCCESS;
    }
}
