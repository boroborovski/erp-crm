<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Filament\Resources\ProjectResource\RelationManagers\MilestonesRelationManager;
use App\Filament\Resources\ProjectResource\RelationManagers\TasksRelationManager;
use App\Models\Project;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    public function getRelationManagers(): array
    {
        return [
            MilestonesRelationManager::class,
            TasksRelationManager::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->icon('heroicon-o-pencil-square')->label(__('resources.actions.edit')),
            RestoreAction::make(),
            DeleteAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('projects.sections.details'))->columnSpanFull()->schema([
                TextEntry::make('name')
                    ->label(__('projects.fields.name')),

                TextEntry::make('status')
                    ->label(__('projects.fields.status'))
                    ->badge(),

                TextEntry::make('company.name')
                    ->label(__('projects.fields.company'))
                    ->placeholder('—'),

                TextEntry::make('opportunity.name')
                    ->label(__('projects.fields.opportunity'))
                    ->placeholder('—'),

                TextEntry::make('start_date')
                    ->label(__('projects.fields.start_date'))
                    ->date()
                    ->placeholder('—'),

                TextEntry::make('end_date')
                    ->label(__('projects.fields.end_date'))
                    ->date()
                    ->placeholder('—'),

                TextEntry::make('description')
                    ->label(__('projects.fields.description'))
                    ->placeholder('—')
                    ->columnSpanFull(),
            ])->columns(3),

            Section::make(__('projects.sections.progress'))->columnSpanFull()->schema([
                TextEntry::make('milestone_progress')
                    ->label(__('projects.sections.milestones'))
                    ->getStateUsing(function (Project $record): string {
                        $total = $record->milestones->count();
                        $done  = $record->milestones->where('is_completed', true)->count();

                        return __('projects.progress.milestones', ['done' => $done, 'total' => $total]);
                    })
                    ->icon('heroicon-o-flag'),

                TextEntry::make('task_progress')
                    ->label(__('projects.sections.tasks'))
                    ->getStateUsing(function (Project $record): string {
                        $total = $record->tasks->count();

                        return __('projects.progress.tasks', ['done' => 0, 'total' => $total]);
                    })
                    ->icon('heroicon-o-check-circle'),
            ])->columns(2),
        ]);
    }
}
