<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Team;
use Illuminate\Console\Command;

final class NotifyLowStock extends Command
{
    protected $signature = 'products:notify-low-stock';

    protected $description = 'Log an activity for teams that have products below the low-stock threshold';

    public function handle(): int
    {
        if (! config('app.stock_alerts_enabled', false)) {
            $this->info('Stock alerts disabled. Set STOCK_ALERTS_ENABLED=true to enable.');

            return self::SUCCESS;
        }

        $products = Product::query()
            ->where('track_stock', true)
            ->whereNotNull('low_stock_threshold')
            ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
            ->with('team')
            ->get();

        if ($products->isEmpty()) {
            $this->info('No low-stock products found.');

            return self::SUCCESS;
        }

        /** @var \Illuminate\Support\Collection<int, Product> $byTeam */
        $byTeam = $products->groupBy('team_id');

        foreach ($byTeam as $teamId => $teamProducts) {
            /** @var Team|null $team */
            $team = $teamProducts->first()?->team;

            if ($team === null) {
                continue;
            }

            $names = $teamProducts->pluck('name')->join(', ');
            $this->info("Team [{$team->name}] — low stock: {$names}");
        }

        $this->info("Checked {$products->count()} low-stock product(s) across {$byTeam->count()} team(s).");

        return self::SUCCESS;
    }
}
