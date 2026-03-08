<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Enums\StockMovementType;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class StockMovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'stockMovements';

    protected static string|\BackedEnum|null $icon = 'heroicon-o-arrow-path';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->heading(__('products.stock.movements_heading'))
            ->columns([
                TextColumn::make('type')
                    ->label(__('products.stock.fields.type'))
                    ->badge()
                    ->formatStateUsing(fn (StockMovementType $state): string => $state->getLabel())
                    ->color(fn (StockMovementType $state): string => (string) $state->getColor()),

                TextColumn::make('quantity')
                    ->label(__('products.stock.fields.quantity'))
                    ->formatStateUsing(function (object $record): string {
                        /** @var \App\Models\StockMovement $record */
                        $type = $record->type;
                        $qty  = (float) $record->quantity;

                        return match ($type) {
                            StockMovementType::Sale       => '−' . number_format($qty, 2),
                            default                       => '+' . number_format($qty, 2),
                        };
                    })
                    ->color(function (object $record): string {
                        /** @var \App\Models\StockMovement $record */
                        return $record->type === StockMovementType::Sale ? 'danger' : 'success';
                    }),

                TextColumn::make('note')
                    ->label(__('products.stock.fields.note'))
                    ->placeholder('—')
                    ->limit(60),

                TextColumn::make('creator.name')
                    ->label(__('products.stock.fields.created_by'))
                    ->placeholder('—'),

                TextColumn::make('created_at')
                    ->label(__('resources.columns.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }
}
