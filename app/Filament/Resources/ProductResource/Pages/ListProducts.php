<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Str;
use Filament\Facades\Filament;

final class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('export_csv')
                ->label(__('products.actions.export_csv'))
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function (): void {
                    $products = Product::query()
                        ->where('team_id', Filament::getTenant()?->getKey())
                        ->with('category')
                        ->get();

                    $headers = [
                        __('products.fields.name'),
                        __('products.fields.sku'),
                        __('products.fields.category'),
                        __('products.fields.unit_price'),
                        __('products.fields.currency'),
                        __('products.fields.unit'),
                        __('products.fields.is_active'),
                    ];

                    $lines = [];
                    $lines[] = collect($headers)
                        ->map(fn (string $h): string => '"' . str_replace('"', '""', $h) . '"')
                        ->implode(',');

                    foreach ($products as $product) {
                        $lines[] = collect([
                            $product->name,
                            $product->sku ?? '',
                            $product->category?->name ?? '',
                            $product->unit_price,
                            $product->currency,
                            $product->unit->getLabel(),
                            $product->is_active ? 'Yes' : 'No',
                        ])
                            ->map(fn ($v): string => '"' . str_replace('"', '""', (string) ($v ?? '')) . '"')
                            ->implode(',');
                    }

                    $csv    = implode("\n", $lines);
                    $base64 = base64_encode($csv);
                    $filename = 'products-' . now()->format('Y-m-d') . '.csv';

                    $this->js("(function(){const a=document.createElement('a');a.href='data:text/csv;charset=utf-8;base64,{$base64}';a.download='{$filename}';document.body.appendChild(a);a.click();document.body.removeChild(a);})();");
                }),

            CreateAction::make()->icon('heroicon-o-plus'),
        ];
    }
}
