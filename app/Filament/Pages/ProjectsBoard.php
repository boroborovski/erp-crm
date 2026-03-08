<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\Team;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Exception\InvalidArgumentException;
use Relaticle\Flowforge\Board;
use Relaticle\Flowforge\BoardPage;
use Relaticle\Flowforge\Column;
use Throwable;

final class ProjectsBoard extends BoardPage
{
    protected static ?string $navigationLabel = 'Board';

    protected static ?string $title = 'Projects';

    protected static ?string $navigationParentItem = 'Projects';

    public static function getNavigationGroup(): ?string
    {
        return __('resources.navigation.groups.erp');
    }

    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-view-columns';

    public function board(Board $board): Board
    {
        return $board
            ->query(
                Project::query()
                    ->where('team_id', Filament::getTenant()?->getKey())
                    ->with(['company'])
            )
            ->recordTitleAttribute('name')
            ->columnIdentifier('status')
            ->positionIdentifier('order_column')
            ->searchable(['name'])
            ->columns($this->getColumns())
            ->cardSchema(fn (Schema $schema): Schema => $schema->components([
                \Filament\Infolists\Components\TextEntry::make('company.name')
                    ->hiddenLabel()
                    ->placeholder('—')
                    ->visible(fn (?string $state): bool => filled($state))
                    ->badge()
                    ->color('gray'),
            ]))
            ->columnActions([
                CreateAction::make()
                    ->label(__('resources.actions.add_opportunity'))
                    ->icon('heroicon-o-plus')
                    ->iconButton()
                    ->modalWidth(Width::Large)
                    ->slideOver(false)
                    ->model(Project::class)
                    ->schema(fn (Schema $schema): Schema => $schema->components([
                        Section::make()->schema([
                            TextInput::make('name')
                                ->label(__('projects.fields.name'))
                                ->required()
                                ->maxLength(255),

                            DatePicker::make('start_date')
                                ->label(__('projects.fields.start_date'))
                                ->nullable(),

                            DatePicker::make('end_date')
                                ->label(__('projects.fields.end_date'))
                                ->nullable(),

                            Textarea::make('description')
                                ->label(__('projects.fields.description'))
                                ->rows(2)
                                ->nullable()
                                ->columnSpanFull(),
                        ])->columns(2),
                    ]))
                    ->using(function (array $data, array $arguments): Project {
                        /** @var Team $currentTeam */
                        $currentTeam = Auth::guard('web')->user()->currentTeam;

                        $data['status'] = ProjectStatus::from($arguments['column']);
                        $data['team_id'] = $currentTeam->getKey();

                        return Project::query()->create($data);
                    }),
            ])
            ->cardActions([
                Action::make('edit')
                    ->label(__('resources.actions.edit'))
                    ->slideOver()
                    ->modalWidth(Width::Large)
                    ->icon('heroicon-o-pencil-square')
                    ->schema(fn (Schema $schema): Schema => $schema->components([
                        Section::make()->schema([
                            TextInput::make('name')
                                ->label(__('projects.fields.name'))
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),

                            Select::make('status')
                                ->label(__('projects.fields.status'))
                                ->options(ProjectStatus::class)
                                ->required(),

                            DatePicker::make('start_date')
                                ->label(__('projects.fields.start_date'))
                                ->nullable(),

                            DatePicker::make('end_date')
                                ->label(__('projects.fields.end_date'))
                                ->nullable(),
                        ])->columns(2),
                    ]))
                    ->fillForm(fn (Project $record): array => [
                        'name'       => $record->name,
                        'status'     => $record->status->value,
                        'start_date' => $record->start_date,
                        'end_date'   => $record->end_date,
                    ])
                    ->action(function (Project $record, array $data): void {
                        $record->update($data);
                    }),

                Action::make('delete')
                    ->label(__('resources.actions.delete'))
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Project $record): void {
                        $record->delete();
                    }),
            ]);
    }

    /**
     * @throws Throwable
     */
    public function moveCard(
        string $cardId,
        string $targetColumnId,
        ?string $afterCardId = null,
        ?string $beforeCardId = null
    ): void {
        $board = $this->getBoard();
        $query = $board->getQuery();

        throw_unless($query instanceof \Illuminate\Database\Eloquent\Builder, InvalidArgumentException::class, 'Board query not available');

        /** @var Project|null $card */
        $card = (clone $query)->find($cardId);
        throw_unless($card, InvalidArgumentException::class, "Card not found: {$cardId}");

        $newPosition = $this->calculatePositionBetweenCards($afterCardId, $beforeCardId, $targetColumnId);

        DB::transaction(function () use ($card, $targetColumnId, $newPosition): void {
            $card->update([
                'status'       => ProjectStatus::from($targetColumnId),
                'order_column' => $newPosition,
            ]);
        });

        $this->dispatch('kanban-card-moved', [
            'cardId'   => $cardId,
            'columnId' => $targetColumnId,
            'position' => $newPosition,
        ]);
    }

    /** @return array<Column> */
    private function getColumns(): array
    {
        return array_map(
            fn (ProjectStatus $status): Column => Column::make($status->value)
                ->color($status->getColor())
                ->label($status->getLabel()),
            ProjectStatus::cases(),
        );
    }

    public static function canAccess(): bool
    {
        $tenant = Filament::getTenant();

        return $tenant instanceof Team && (bool) $tenant->erp_enabled;
    }
}
