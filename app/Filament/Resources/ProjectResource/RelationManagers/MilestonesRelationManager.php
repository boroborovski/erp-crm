<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Size;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class MilestonesRelationManager extends RelationManager
{
    protected static string $relationship = 'milestones';

    protected static string|\BackedEnum|null $icon = 'heroicon-o-flag';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label(__('projects.fields.name'))
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            DatePicker::make('due_date')
                ->label(__('projects.fields.due_date'))
                ->nullable(),

            Toggle::make('is_completed')
                ->label(__('projects.fields.is_completed'))
                ->default(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->heading(__('projects.sections.milestones'))
            ->columns([
                TextColumn::make('name')
                    ->label(__('projects.fields.name'))
                    ->searchable(),

                TextColumn::make('due_date')
                    ->label(__('projects.fields.due_date'))
                    ->date()
                    ->placeholder('—')
                    ->sortable(),

                IconColumn::make('is_completed')
                    ->label(__('projects.fields.is_completed'))
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label(__('resources.columns.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('due_date')
            ->headerActions([
                CreateAction::make()->icon('heroicon-o-plus')->size(Size::Small),
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
