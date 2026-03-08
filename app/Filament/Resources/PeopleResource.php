<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\CreationSource;
use App\Filament\Exports\PeopleExporter;
use App\Filament\Resources\PeopleResource\Pages\ListPeople;
use App\Filament\Resources\PeopleResource\Pages\ViewPeople;
use App\Filament\Resources\PeopleResource\RelationManagers\InvoicesRelationManager;
use App\Filament\Resources\PeopleResource\RelationManagers\NotesRelationManager;
use App\Filament\Resources\PeopleResource\RelationManagers\QuotesRelationManager;
use App\Filament\Resources\PeopleResource\RelationManagers\TasksRelationManager;
use App\Models\Company;
use App\Models\People;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Relaticle\CustomFields\Facades\CustomFields;

final class PeopleResource extends Resource
{
    protected static ?string $model = People::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('resources.navigation.groups.workspace');
    }

    public static function getModelLabel(): string
    {
        return __('resources.models.people.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.models.people.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(7),
                        Select::make('company_id')
                            ->relationship('company', 'name')
                            ->suffixAction(
                                Action::make('Create Company')
                                    ->model(Company::class)
                                    ->schema(fn (Schema $schema): Schema => $schema->components([
                                        TextInput::make('name')
                                            ->required(),
                                        Select::make('account_owner_id')
                                            ->model(Company::class)
                                            ->relationship('accountOwner', 'name')
                                            ->label(__('resources.columns.account_owner'))
                                            ->preload()
                                            ->searchable(),
                                        CustomFields::form()->forModel(Company::class)->build()->columns(1),
                                    ]))
                                    ->modalWidth(Width::Large)
                                    ->slideOver()
                                    ->icon('heroicon-o-plus')
                                    ->action(function (array $data, Set $set): void {
                                        $company = Company::query()->create($data);
                                        $set('company_id', $company->id);
                                    })
                            )
                            ->searchable()
                            ->preload()
                            ->columnSpan(5),
                    ])
                    ->columns(12),
                CustomFields::form()->build()->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('resources.columns.person'))
                    ->searchable()
                    ->sortable()
                    ->view('filament.tables.columns.avatar-name-column'),
                TextColumn::make('company.name')
                    ->label(__('resources.columns.company'))
                    ->url(fn (People $record): ?string => $record->company_id ? CompanyResource::getUrl('view', [$record->company_id]) : null)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('creator.name')
                    ->label(__('resources.columns.created_by'))
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->getStateUsing(fn (People $record): string => $record->created_by),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('creation_source')
                    ->label(__('resources.filters.creation_source'))
                    ->options(CreationSource::class)
                    ->multiple(),
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
            ->toolbarActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->exporter(PeopleExporter::class),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            QuotesRelationManager::class,
            InvoicesRelationManager::class,
            TasksRelationManager::class,
            NotesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPeople::route('/'),
            'view' => ViewPeople::route('/{record}'),
        ];
    }

    /**
     * @return Builder<People>
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['team', 'customFieldValues.customField.options'])
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
