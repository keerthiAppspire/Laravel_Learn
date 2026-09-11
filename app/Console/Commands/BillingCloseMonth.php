<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Facades\DB;

#[Signature('billing:close-month {period} {--force}')]
#[Description('Close all invoices for a given month')]
class BillingCloseMonth extends Command
{
    use ConfirmableTrait;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->confirmToProceed();
        $period = $this->argument('period');
        $invoices = Invoice::whereYear('due_date', substr($period, 0, 4))
            ->whereMonth('due_date', substr($period, 5, 2))
            ->get();
        $this->info('invoices found: '.$invoices->count());
        try {
            DB::transaction(function () use ($invoices) {
                foreach ($invoices as $invoice) {
                    $invoice->update([
                        'status' => 'closed',
                    ]);
                }
            });
        } catch (\Throwable $e) {
            $this->error('Failed to close month: '.$period);

            return self::FAILURE;
        }
        $this->info('closing month: '.$period);

        return self::SUCCESS;
    }
}
