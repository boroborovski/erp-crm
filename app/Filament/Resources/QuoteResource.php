<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\QuoteStatus;
use App\Filament\Resources\QuoteResource\Pages\CreateQuote;
use App\Filament\Resources\QuoteResource\Pages\EditQuote;
use App\Filament\Resources\QuoteResource\Pages\ListQuotes;
use App\Filament\Resources\QuoteResource\Pages\ViewQuote;
use App\Models\Company;
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
use Filament\Schemas\Components\Utilities\Get;
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

final class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 2;

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
        return __('quotes.navigation.label');
    }

    public static function getModelLabel(): string
    {
        return __('resources.models.quote.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.models.quote.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('quotes.sections.details'))->schema([
                TextInput::make('quote_number')
                    ->label(__('quotes.fields.quote_number'))
                    ->disabled()
                    ->placeholder(__('quotes.fields.quote_number_placeholder'))
                    ->dehydrated(false),

                Select::make('status')
                    ->label(__('quotes.fields.status'))
                    ->options(QuoteStatus::class)
                    ->required()
                    ->default(QuoteStatus::Draft->value),

                Select::make('opportunity_id')
                    ->label(__('quotes.fields.opportunity'))
                    ->options(fn (): array => Opportunity::query()
                        ->where('team_id', Filament::getTenant()?->getKey())
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->all())
                    ->searchable()
                    ->nullable(),

                Select::make('company_id')
                    ->label(__('quotes.fields.company'))
                    ->options(fn (): array => Company::query()
                        ->where('team_id', Filament::getTenant()?->getKey())
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->all())
                    ->searchable()
                    ->nullable(),

                Select::make('contact_id')
                    ->label(__('quotes.fields.contact'))
                    ->options(fn (): array => People::query()
                        ->where('team_id', Filament::getTenant()?->getKey())
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->all())
                    ->searchable()
                    ->nullable(),

                DatePicker::make('valid_until')
                    ->label(__('quotes.fields.valid_until'))
                    ->nullable(),

                Textarea::make('notes')
                    ->label(__('quotes.fields.notes'))
                    ->rows(3)
                    ->nullable()
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make(__('quotes.sections.line_items'))->schema([
                Repeater::make('lineItems')
                    ->relationship('lineItems')
                    ->label('')
                    ->schema([
                        Select::make('product_id')
                            ->label(__('quotes.fields.product'))
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
                            ->label(__('quotes.fields.description'))
                            ->required()
                            ->maxLength(500)
                            ->columnSpanFull(),

                        TextInput::make('quantity')
                            ->label(__('quotes.fields.quantity'))
                            ->numeric()
                            ->required()
                            ->minValue(0.0001)
                            ->default(1),

                        TextInput::make('unit_price')
                            ->label(__('quotes.fields.unit_price'))
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->default(0)
                            ->prefix('$'),

                        TextInput::make('discount_pct')
                            ->label(__('quotes.fields.discount_pct'))
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(0)
                            ->suffix('%'),

                        TextInput::make('tax_pct')
                            ->label(__('quotes.fields.tax_pct'))
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(0)
                            ->suffix('%'),
                    ])
                    ->orderColumn('sort_order')
                    ->columns(2)
                    ->addActionLabel(__('quotes.actions.add_line_item'))
                    ->collapsible()
                    ->reorderable(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('quote_number')
                    ->label(__('quotes.fields.quote_number'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('quotes.fields.status'))
                    ->badge()
                    ->sortable(),

                TextColumn::make('opportunity.name')
                    ->label(__('quotes.fields.opportunity'))
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('company.name')
                    ->label(__('quotes.fields.company'))
                    ->placeholder('—')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('contact.name')
                    ->label(__('quotes.fields.contact'))
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('valid_until')
                    ->label(__('quotes.fields.valid_until'))
                    ->date()
                    ->sortable()
                    ->color(fn (Quote $record): string => match (true) {
                        $record->valid_until === null                       => 'gray',
                        $record->valid_until->isPast()                     => 'danger',
                        $record->valid_until->diffInDays(Carbon::today()) <= 7 => 'warning',
                        default                                            => 'success',
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
                    ->label(__('quotes.fields.status'))
                    ->options(QuoteStatus::class),

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
            'index'  => ListQuotes::route('/'),
            'create' => CreateQuote::route('/create'),
            'edit'   => EditQuote::route('/{record}/edit'),
            'view'   => ViewQuote::route('/{record}'),
        ];
    }

    /** @return Builder<Quote> */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['team', 'opportunity', 'company', 'contact'])
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
