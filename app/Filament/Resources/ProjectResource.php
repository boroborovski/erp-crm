<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\ProjectStatus;
use App\Filament\Resources\ProjectResource\Pages\CreateProject;
use App\Filament\Resources\ProjectResource\Pages\EditProject;
use App\Filament\Resources\ProjectResource\Pages\ListProjects;
use App\Filament\Resources\ProjectResource\Pages\ViewProject;
use App\Filament\Resources\ProjectResource\RelationManagers\MilestonesRelationManager;
use App\Filament\Resources\ProjectResource\RelationManagers\TasksRelationManager;
use App\Models\Company;
use App\Models\Opportunity;
use App\Models\Project;
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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Override;

final class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    protected static ?int $navigationSort = 4;

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
        return __('projects.navigation.label');
    }

    public static function getModelLabel(): string
    {
        return __('resources.models.project.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.models.project.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('projects.sections.details'))->schema([
                TextInput::make('name')
                    ->label(__('projects.fields.name'))
                    ->required()
                    ->maxLength(255),

                Select::make('status')
                    ->label(__('projects.fields.status'))
                    ->options(ProjectStatus::class)
                    ->required()
                    ->default(ProjectStatus::Planning->value),

                Select::make('company_id')
                    ->label(__('projects.fields.company'))
                    ->options(fn (): array => Company::query()
                        ->where('team_id', Filament::getTenant()?->getKey())
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->all())
                    ->searchable()
                    ->nullable(),

                Select::make('opportunity_id')
                    ->label(__('projects.fields.opportunity'))
                    ->options(fn (): array => Opportunity::query()
                        ->where('team_id', Filament::getTenant()?->getKey())
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->all())
                    ->searchable()
                    ->nullable(),

                DatePicker::make('start_date')
                    ->label(__('projects.fields.start_date'))
                    ->nullable(),

                DatePicker::make('end_date')
                    ->label(__('projects.fields.end_date'))
                    ->nullable(),

                Textarea::make('description')
                    ->label(__('projects.fields.description'))
                    ->rows(3)
                    ->nullable()
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('projects.fields.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('projects.fields.status'))
                    ->badge()
                    ->sortable(),

                TextColumn::make('company.name')
                    ->label(__('projects.fields.company'))
                    ->placeholder('—')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label(__('projects.fields.start_date'))
                    ->date()
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('end_date')
                    ->label(__('projects.fields.end_date'))
                    ->date()
                    ->sortable()
                    ->placeholder('—')
                    ->color(fn (Project $record): string => match (true) {
                        $record->end_date === null                                   => 'gray',
                        $record->status === ProjectStatus::Completed                 => 'gray',
                        $record->status === ProjectStatus::Cancelled                 => 'gray',
                        $record->end_date->isPast()                                  => 'danger',
                        $record->end_date->diffInDays(now()) <= 7                   => 'warning',
                        default                                                      => 'success',
                    }),

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
                    ->label(__('projects.filters.status'))
                    ->options(ProjectStatus::class),

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

    public static function getRelationManagers(): array
    {
        return [
            MilestonesRelationManager::class,
            TasksRelationManager::class,
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index'  => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit'   => EditProject::route('/{record}/edit'),
            'view'   => ViewProject::route('/{record}'),
        ];
    }

    /** @return Builder<Project> */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['team', 'company', 'opportunity', 'milestones', 'tasks'])
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
