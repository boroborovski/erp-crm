<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\InvoiceStatus;
use App\Filament\Resources\InvoiceResource\Pages\CreateInvoice;
use App\Filament\Resources\InvoiceResource\Pages\EditInvoice;
use App\Filament\Resources\InvoiceResource\Pages\ListInvoices;
use App\Filament\Resources\InvoiceResource\Pages\ViewInvoice;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Opportunity;
use App\Models\People;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Team;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Override;

final class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-currency-dollar';

    protected static ?int $navigationSort = 3;

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
        return __('invoices.navigation.label');
    }

    public static function getModelLabel(): string
    {
        return __('resources.models.invoice.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.models.invoice.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('invoices.sections.details'))->schema([
                TextInput::make('invoice_number')
                    ->label(__('invoices.fields.invoice_number'))
                    ->disabled()
                    ->placeholder(__('invoices.fields.invoice_number_placeholder'))
                    ->dehydrated(false),

                Select::make('status')
                    ->label(__('invoices.fields.status'))
                    ->options(InvoiceStatus::class)
                    ->required()
                    ->default(InvoiceStatus::Draft->value),

                Select::make('quote_id')
                    ->label(__('invoices.fields.quote'))
                    ->options(fn (): array => Quote::query()
                        ->where('team_id', Filament::getTenant()?->getKey())
                        ->orderBy('quote_number')
                        ->pluck('quote_number', 'id')
                        ->all())
                    ->searchable()
                    ->nullable(),

                Select::make('company_id')
                    ->label(__('invoices.fields.company'))
                    ->options(fn (): array => Company::query()
                        ->where('team_id', Filament::getTenant()?->getKey())
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->all())
                    ->searchable()
                    ->nullable(),

                Select::make('contact_id')
                    ->label(__('invoices.fields.contact'))
                    ->options(fn (): array => People::query()
                        ->where('team_id', Filament::getTenant()?->getKey())
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->all())
                    ->searchable()
                    ->nullable(),

                DatePicker::make('issue_date')
                    ->label(__('invoices.fields.issue_date'))
                    ->required()
                    ->default(now()),

                DatePicker::make('due_date')
                    ->label(__('invoices.fields.due_date'))
                    ->nullable(),

                Textarea::make('notes')
                    ->label(__('invoices.fields.notes'))
                    ->rows(3)
                    ->nullable()
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make(__('invoices.sections.line_items'))->schema([
                Repeater::make('lineItems')
                    ->relationship('lineItems')
                    ->label('')
                    ->schema([
                        Select::make('product_id')
                            ->label(__('invoices.fields.product'))
                            ->options(fn (): array => Product::query()
                                ->where('team_id', Filament::getTenant()?->getKey())
                                ->where('is_active', true)
                                ->orderBy('name')
                                ->pluck('name', 'id')
                                ->all())
                            ->searchable()
                            ->nullable()
                            ->live()
                            ->afterStateUpdated(function (?string $state, Set $set): void {
                                if ($state === null) {
                                    return;
                                }

                                $product = Product::find($state);

                                if ($product) {
                                    $set('description', $product->name);
                                    $set('unit_price', (string) $product->unit_price);
                                }
                            })
                            ->columnSpanFull(),

                        TextInput::make('description')
                            ->label(__('invoices.fields.description'))
                            ->required()
                            ->maxLength(500)
                            ->columnSpanFull(),

                        TextInput::make('quantity')
                            ->label(__('invoices.fields.quantity'))
                            ->numeric()
                            ->required()
                            ->minValue(0.0001)
                            ->default(1),

                        TextInput::make('unit_price')
                            ->label(__('invoices.fields.unit_price'))
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->default(0)
                            ->prefix('$'),

                        TextInput::make('discount_pct')
                            ->label(__('invoices.fields.discount_pct'))
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(0)
                            ->suffix('%'),

                        TextInput::make('tax_pct')
                            ->label(__('invoices.fields.tax_pct'))
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(0)
                            ->suffix('%'),
                    ])
                    ->orderColumn('sort_order')
                    ->columns(2)
                    ->addActionLabel(__('invoices.actions.add_line_item'))
                    ->collapsible()
                    ->reorderable(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->label(__('invoices.fields.invoice_number'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('invoices.fields.status'))
                    ->badge()
                    ->sortable(),

                TextColumn::make('company.name')
                    ->label(__('invoices.fields.company'))
                    ->placeholder('—')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('contact.name')
                    ->label(__('invoices.fields.contact'))
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('issue_date')
                    ->label(__('invoices.fields.issue_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('due_date')
                    ->label(__('invoices.fields.due_date'))
                    ->date()
                    ->sortable()
                    ->color(fn (Invoice $record): string => match (true) {
                        $record->due_date === null                                                               => 'gray',
                        in_array($record->status, [InvoiceStatus::Paid, InvoiceStatus::Void], true)            => 'gray',
                        $record->due_date->isPast()                                                            => 'danger',
                        $record->due_date->diffInDays(Carbon::today()) <= 7                                    => 'warning',
                        default                                                                                => 'success',
                    })
                    ->placeholder('—'),

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
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label(__('invoices.filters.status'))
                    ->options(InvoiceStatus::class),

                TrashedFilter::make(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    RestoreAction::make(),
                    DeleteAction::make(),
                    ForceDeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    RestoreBulkAction::make(),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index'  => ListInvoices::route('/'),
            'create' => CreateInvoice::route('/create'),
            'edit'   => EditInvoice::route('/{record}/edit'),
            'view'   => ViewInvoice::route('/{record}'),
        ];
    }

    /** @return Builder<Invoice> */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['team', 'quote', 'company', 'contact'])
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
