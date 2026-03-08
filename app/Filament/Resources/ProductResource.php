<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\ProductUnit;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Filament\Resources\ProductResource\Pages\ViewProduct;
use App\Filament\Resources\ProductResource\RelationManagers\StockMovementsRelationManager;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Team;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Override;

final class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cube';

    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        $tenant = Filament::getTenant();

        return $tenant instanceof Team && (bool) $tenant->erp_enabled;
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.navigation.groups.erp');
    }

    public static function getNavigationLabel(): string
    {
        return __('products.navigation.label');
    }

    public static function getModelLabel(): string
    {
        return __('resources.models.product.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.models.product.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('products.sections.basic_info'))->schema([
                TextInput::make('name')
                    ->label(__('products.fields.name'))
                    ->required()
                    ->maxLength(255),

                TextInput::make('sku')
                    ->label(__('products.fields.sku'))
                    ->nullable()
                    ->maxLength(100),

                Select::make('product_category_id')
                    ->label(__('products.fields.category'))
                    ->options(fn (): array => ProductCategory::query()
                        ->where('team_id', Filament::getTenant()?->getKey())
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->all())
                    ->searchable()
                    ->nullable()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label(__('products.fields.name'))
                            ->required()
                            ->maxLength(255),
                    ])
                    ->createOptionUsing(function (array $data): string {
                        /** @var ProductCategory $category */
                        $category = ProductCategory::create([
                            'team_id' => Filament::getTenant()?->getKey(),
                            'name'    => $data['name'],
                        ]);

                        return $category->getKey();
                    }),

                Toggle::make('is_active')
                    ->label(__('products.fields.is_active'))
                    ->default(true),
            ])->columns(2),

            Section::make(__('products.sections.pricing'))->schema([
                TextInput::make('unit_price')
                    ->label(__('products.fields.unit_price'))
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->default(0),

                Select::make('currency')
                    ->label(__('products.fields.currency'))
                    ->options([
                        'USD' => 'USD — US Dollar',
                        'EUR' => 'EUR — Euro',
                        'GBP' => 'GBP — British Pound',
                        'BGN' => 'BGN — Bulgarian Lev',
                        'CAD' => 'CAD — Canadian Dollar',
                        'AUD' => 'AUD — Australian Dollar',
                        'CHF' => 'CHF — Swiss Franc',
                        'JPY' => 'JPY — Japanese Yen',
                    ])
                    ->searchable()
                    ->required()
                    ->default('USD'),

                Select::make('unit')
                    ->label(__('products.fields.unit'))
                    ->options(ProductUnit::selectOptions())
                    ->required()
                    ->default(ProductUnit::Each->value),
            ])->columns(3),

            Section::make(__('products.sections.stock'))->schema([
                Toggle::make('track_stock')
                    ->label(__('products.stock.fields.track_stock'))
                    ->default(false)
                    ->live(),

                TextInput::make('stock_quantity')
                    ->label(__('products.stock.fields.stock_quantity'))
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->visible(fn (\Filament\Schemas\Components\Utilities\Get $get): bool => (bool) $get('track_stock')),

                TextInput::make('low_stock_threshold')
                    ->label(__('products.stock.fields.low_stock_threshold'))
                    ->numeric()
                    ->nullable()
                    ->visible(fn (\Filament\Schemas\Components\Utilities\Get $get): bool => (bool) $get('track_stock')),
            ])->columns(3),

            Section::make()->schema([
                Textarea::make('description')
                    ->label(__('products.fields.description'))
                    ->rows(4)
                    ->nullable()
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('products.fields.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('sku')
                    ->label(__('products.fields.sku'))
                    ->searchable()
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('category.name')
                    ->label(__('products.fields.category'))
                    ->placeholder('—')
                    ->sortable(),

                TextColumn::make('unit_price')
                    ->label(__('products.fields.unit_price'))
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),

                TextColumn::make('currency')
                    ->label(__('products.fields.currency'))
                    ->badge()
                    ->color('gray'),

                TextColumn::make('unit')
                    ->label(__('products.fields.unit'))
                    ->formatStateUsing(fn (ProductUnit $state): string => $state->getLabel())
                    ->badge()
                    ->color('info'),

                TextColumn::make('stock_quantity')
                    ->label(__('products.stock.fields.stock_quantity'))
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_active')
                    ->label(__('products.fields.is_active'))
                    ->boolean()
                    ->sortable(),

                IconColumn::make('low_stock_warning')
                    ->label(__('products.stock.fields.low_stock_warning'))
                    ->getStateUsing(fn (Product $record): bool => $record->isLowStock())
                    ->icon(fn (bool $state): string => $state ? 'heroicon-o-exclamation-triangle' : '')
                    ->color(fn (bool $state): ?string => $state ? 'warning' : null)
                    ->tooltip(fn (Product $record): ?string => $record->isLowStock() ? __('products.stock.low_stock_warning') : null)
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('resources.columns.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('resources.columns.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('product_category_id')
                    ->label(__('products.filters.category'))
                    ->options(fn (): array => ProductCategory::query()
                        ->where('team_id', Filament::getTenant()?->getKey())
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->all())
                    ->searchable(),

                TernaryFilter::make('is_active')
                    ->label(__('products.filters.is_active'))
                    ->trueLabel(__('products.fields.is_active'))
                    ->falseLabel('Inactive'),

                Filter::make('price_range')
                    ->form([
                        TextInput::make('min_price')
                            ->label(__('products.filters.min_price'))
                            ->numeric()
                            ->nullable(),
                        TextInput::make('max_price')
                            ->label(__('products.filters.max_price'))
                            ->numeric()
                            ->nullable(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_price'] !== null && $data['min_price'] !== '',
                                fn (Builder $q): Builder => $q->where('unit_price', '>=', $data['min_price']),
                            )
                            ->when(
                                $data['max_price'] !== null && $data['max_price'] !== '',
                                fn (Builder $q): Builder => $q->where('unit_price', '<=', $data['max_price']),
                            );
                    }),

                Filter::make('low_stock')
                    ->label(__('products.filters.low_stock'))
                    ->query(fn (Builder $query): Builder => $query
                        ->where('track_stock', true)
                        ->whereNotNull('low_stock_threshold')
                        ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')),
            ])
            ->defaultSort('name')
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('activate')
                        ->label(__('products.bulk_actions.activate'))
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_active' => true]);
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('deactivate')
                        ->label(__('products.bulk_actions.deactivate'))
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_active' => false]);
                        })
                        ->deselectRecordsAfterCompletion(),

                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            StockMovementsRelationManager::class,
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index'  => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit'   => EditProduct::route('/{record}/edit'),
            'view'   => ViewProduct::route('/{record}'),
        ];
    }
}
