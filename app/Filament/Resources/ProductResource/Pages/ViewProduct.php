<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductResource\Pages;

use App\Enums\ProductUnit;
use App\Enums\StockMovementType;
use App\Filament\Resources\ProductResource;
use App\Models\Product;
use App\Models\StockMovement;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('adjust_stock')
                ->label(__('products.stock.actions.adjust_stock'))
                ->icon('heroicon-o-adjustments-horizontal')
                ->color('warning')
                ->visible(fn (): bool => (bool) $this->record->track_stock)
                ->modalHeading(__('products.stock.actions.adjust_stock'))
                ->modalSubmitActionLabel(__('products.stock.actions.submit'))
                ->form([
                    Select::make('type')
                        ->label(__('products.stock.fields.type'))
                        ->options([
                            StockMovementType::Restock->value    => StockMovementType::Restock->getLabel(),
                            StockMovementType::Adjustment->value => StockMovementType::Adjustment->getLabel(),
                            StockMovementType::Return->value     => StockMovementType::Return->getLabel(),
                        ])
                        ->required()
                        ->default(StockMovementType::Restock->value),

                    TextInput::make('quantity')
                        ->label(__('products.stock.fields.quantity'))
                        ->numeric()
                        ->required()
                        ->minValue(0.01),

                    Textarea::make('note')
                        ->label(__('products.stock.fields.note'))
                        ->nullable()
                        ->rows(2),
                ])
                ->action(function (array $data): void {
                    /** @var Product $product */
                    $product = $this->record;

                    $type  = StockMovementType::from($data['type']);
                    $qty   = (float) $data['quantity'];
                    $delta = $type->quantityDelta($qty);

                    DB::transaction(function () use ($product, $type, $qty, $delta, $data): void {
                        StockMovement::query()->create([
                            'team_id'    => Filament::getTenant()?->getKey(),
                            'product_id' => $product->getKey(),
                            'type'       => $type,
                            'quantity'   => $qty,
                            'note'       => $data['note'] ?? null,
                            'created_by' => Auth::id(),
                        ]);

                        $product->increment('stock_quantity', $delta);
                    });

                    Notification::make()
                        ->title(__('products.stock.notifications.adjusted'))
                        ->success()
                        ->send();

                    $this->redirect($this->getUrl(), navigate: true);
                }),

            EditAction::make()->icon('heroicon-o-pencil-square')->label(__('resources.actions.edit')),
            DeleteAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('products.sections.basic_info'))->schema([
                TextEntry::make('name')
                    ->label(__('products.fields.name')),

                TextEntry::make('sku')
                    ->label(__('products.fields.sku'))
                    ->placeholder('—'),

                TextEntry::make('category.name')
                    ->label(__('products.fields.category'))
                    ->placeholder('—'),

                IconEntry::make('is_active')
                    ->label(__('products.fields.is_active'))
                    ->boolean(),
            ])->columns(2),

            Section::make(__('products.sections.pricing'))->schema([
                TextEntry::make('unit_price')
                    ->label(__('products.fields.unit_price'))
                    ->numeric(decimalPlaces: 2),

                TextEntry::make('currency')
                    ->label(__('products.fields.currency'))
                    ->badge()
                    ->color('gray'),

                TextEntry::make('unit')
                    ->label(__('products.fields.unit'))
                    ->formatStateUsing(fn (ProductUnit $state): string => $state->getLabel())
                    ->badge()
                    ->color('info'),
            ])->columns(3),

            Section::make(__('products.sections.stock'))->schema([
                TextEntry::make('stock_quantity')
                    ->label(__('products.stock.fields.stock_quantity'))
                    ->numeric(decimalPlaces: 2)
                    ->size('lg')
                    ->weight('bold')
                    ->color(fn (Product $record): string => $record->isLowStock() ? 'danger' : 'success'),

                TextEntry::make('low_stock_threshold')
                    ->label(__('products.stock.fields.low_stock_threshold'))
                    ->numeric(decimalPlaces: 2)
                    ->placeholder('—'),
            ])
            ->columns(2)
            ->visible(fn (): bool => (bool) $this->record->track_stock),

            Section::make()->schema([
                TextEntry::make('description')
                    ->label(__('products.fields.description'))
                    ->placeholder('—')
                    ->columnSpanFull(),
            ])->visible(fn (): bool => filled($this->record->description)),
        ]);
    }
}

