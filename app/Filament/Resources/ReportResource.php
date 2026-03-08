<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\ReportEntity;
use App\Filament\Resources\ReportResource\Pages\CreateReport;
use App\Filament\Resources\ReportResource\Pages\EditReport;
use App\Filament\Resources\ReportResource\Pages\ListReports;
use App\Filament\Resources\ReportResource\Pages\ViewReport;
use App\Models\Report;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\CheckboxList;
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
use Filament\Tables\Table;
use Override;

final class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return __('resources.navigation.groups.workspace');
    }

    public static function getNavigationLabel(): string
    {
        return __('reports.navigation.label');
    }

    public static function getModelLabel(): string
    {
        return __('resources.models.report.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.models.report.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('reports.builder.heading'))->schema([
                TextInput::make('name')
                    ->label(__('reports.builder.fields.name'))
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label(__('reports.builder.fields.description'))
                    ->rows(2)
                    ->nullable()
                    ->columnSpanFull(),

                Select::make('entity')
                    ->label(__('reports.builder.fields.entity'))
                    ->options(ReportEntity::selectOptions())
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set): void {
                        $set('columns', []);
                        $set('filters', []);
                    })
                    ->columnSpanFull(),

                CheckboxList::make('columns')
                    ->label(__('reports.builder.fields.columns'))
                    ->options(fn (Get $get): array => ReportEntity::tryFrom((string) $get('entity'))?->getAvailableColumns() ?? [])
                    ->helperText(fn (Get $get): ?string => $get('entity') ? null : __('reports.builder.no_columns_hint'))
                    ->columns(3)
                    ->columnSpanFull(),

                Repeater::make('filters')
                    ->label(__('reports.builder.fields.filters'))
                    ->schema([
                        Select::make('field')
                            ->label(__('reports.builder.fields.filter_field'))
                            ->options(fn (Get $get): array => ReportEntity::tryFrom((string) $get('../../entity'))?->getFilterableFields() ?? [])
                            ->required()
                            ->live(),

                        Select::make('operator')
                            ->label(__('reports.builder.fields.filter_operator'))
                            ->options(ReportEntity::filterOperators())
                            ->required()
                            ->live()
                            ->default('equals'),

                        TextInput::make('value')
                            ->label(__('reports.builder.fields.filter_value'))
                            ->hidden(fn (Get $get): bool => in_array($get('operator'), ['is_empty', 'is_not_empty'], true))
                            ->nullable(),
                    ])
                    ->columns(3)
                    ->addActionLabel(__('reports.builder.add_filter'))
                    ->defaultItems(0)
                    ->columnSpanFull(),
            ])->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('reports.builder.fields.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('entity')
                    ->label(__('reports.builder.fields.entity'))
                    ->formatStateUsing(fn (ReportEntity $state): string => $state->getLabel())
                    ->badge()
                    ->color('primary'),
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
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ]);
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListReports::route('/'),
            'create' => CreateReport::route('/create'),
            'edit' => EditReport::route('/{record}/edit'),
            'view' => ViewReport::route('/{record}'),
        ];
    }
}
