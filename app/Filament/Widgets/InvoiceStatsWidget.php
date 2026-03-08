<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Team;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

final class InvoiceStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 10;

    public static function canView(): bool
    {
        $tenant = Filament::getTenant();

        return $tenant instanceof Team && (bool) $tenant->erp_enabled;
    }

    protected function getStats(): array
    {
        $teamId    = Filament::getTenant()?->getKey();
        $monthStart = now()->startOfMonth();
        $monthEnd   = now()->endOfMonth();

        $invoiceIds = Invoice::query()
            ->where('team_id', $teamId)
            ->whereBetween('issue_date', [$monthStart->toDateString(), $monthEnd->toDateString()])
            ->whereNotIn('status', [InvoiceStatus::Void->value])
            ->pluck('id');

        $totalInvoiced = Invoice::query()
            ->whereIn('id', $invoiceIds)
            ->with('lineItems')
            ->get()
            ->sum(fn (Invoice $inv): float => $inv->grand_total);

        $totalPaid = Payment::query()
            ->whereIn('invoice_id', $invoiceIds)
            ->whereBetween('paid_at', [$monthStart, $monthEnd])
            ->sum('amount');

        $outstanding = max(0.0, $totalInvoiced - (float) $totalPaid);

        return [
            Stat::make(__('invoices.widgets.total_invoiced'), '$' . number_format($totalInvoiced, 2))
                ->description(__('invoices.widgets.heading'))
                ->icon('heroicon-o-document-currency-dollar')
                ->color('info'),

            Stat::make(__('invoices.widgets.total_paid'), '$' . number_format((float) $totalPaid, 2))
                ->description(__('invoices.widgets.heading'))
                ->icon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make(__('invoices.widgets.outstanding_balance'), '$' . number_format($outstanding, 2))
                ->description(__('invoices.widgets.heading'))
                ->icon('heroicon-o-exclamation-triangle')
                ->color($outstanding > 0 ? 'danger' : 'success'),
        ];
    }
}
