<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Filament\Resources\TaskResource\Forms\TaskForm;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Size;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    protected static string|\BackedEnum|null $icon = 'heroicon-o-check-circle';

    public function form(Schema $schema): Schema
    {
        return TaskForm::get($schema, ['project_id']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->heading(__('projects.sections.tasks'))
            ->columns([
                TextColumn::make('title')
                    ->label(__('resources.columns.title'))
                    ->searchable(),

                TextColumn::make('assignees.name')
                    ->label(__('resources.columns.assignee'))
                    ->badge()
                    ->color('primary')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label(__('resources.columns.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make()
                    ->icon('heroicon-o-plus')
                    ->size(Size::Small)
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['team_id'] = Filament::getTenant()?->getKey();

                        return $data;
                    }),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
