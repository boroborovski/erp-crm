<?php

declare(strict_types=1);

namespace App\Filament\Resources\TaskResource\Forms;

use App\Models\Project;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Relaticle\CustomFields\Facades\CustomFields;

final class TaskForm
{
    /**
     * @param  array<string>  $excludeFields
     *
     * @throws \Exception
     */
    public static function get(Schema $schema, array $excludeFields = []): Schema
    {
        $components = [
            TextInput::make('title')
                ->required()
                ->columnSpanFull(),
        ];

        if (! in_array('companies', $excludeFields)) {
            $components[] = Select::make('companies')
                ->label(__('resources.columns.companies'))
                ->multiple()
                ->relationship('companies', 'name')
                ->columnSpanFull();
        }

        if (! in_array('people', $excludeFields)) {
            $components[] = Select::make('people')
                ->label(__('resources.columns.people'))
                ->multiple()
                ->relationship('people', 'name')
                ->nullable();
        }

        if (! in_array('project_id', $excludeFields)) {
            $components[] = Select::make('project_id')
                ->label(__('resources.models.project.singular'))
                ->options(fn (): array => Project::query()
                    ->where('team_id', Filament::getTenant()?->getKey())
                    ->orderBy('name')
                    ->pluck('name', 'id')
                    ->all())
                ->searchable()
                ->nullable()
                ->columnSpanFull();
        }

        $components[] = Select::make('assignees')
            ->label(__('resources.columns.assignees'))
            ->multiple()
            ->relationship('assignees', 'name')
            ->nullable();

        $components[] = CustomFields::form()->except($excludeFields)->build()->columnSpanFull()->columns(1);

        return $schema
            ->components($components)
            ->columns(2);
    }
}
