<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use Illuminate\Console\Command;

final class MarkOverdueInvoices extends Command
{
    protected $signature = 'invoices:mark-overdue';

    protected $description = 'Mark issued invoices past their due date as overdue';

    public function handle(): int
    {
        $count = Invoice::query()
            ->whereIn('status', [InvoiceStatus::Issued->value, InvoiceStatus::Partial->value])
            ->whereNotNull('due_date')
            ->where('due_date', '<', now()->toDateString())
            ->update(['status' => InvoiceStatus::Overdue->value]);

        $this->info("Marked {$count} invoice(s) as overdue.");

        return self::SUCCESS;
    }
}
