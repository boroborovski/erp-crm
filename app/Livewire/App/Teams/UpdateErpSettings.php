<?php

declare(strict_types=1);

namespace App\Livewire\App\Teams;

use App\Livewire\BaseLivewireComponent;
use App\Models\Team;
use Filament\Actions\Action;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;

final class UpdateErpSettings extends BaseLivewireComponent
{
    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public Team $team;

    public function mount(Team $team): void
    {
        $this->team = $team;

        $this->form->fill($team->only(['erp_enabled']));
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('teams.sections.erp_settings.title'))
                    ->aside()
                    ->description(__('teams.sections.erp_settings.description'))
                    ->schema([
                        Toggle::make('erp_enabled')
                            ->label(__('teams.form.erp_enabled.label'))
                            ->helperText(__('teams.form.erp_enabled.helper_text')),
                        Actions::make([
                            Action::make('save')
                                ->label(__('teams.actions.save'))
                                ->action(fn () => $this->save()),
                        ])->alignEnd(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->team->update(['erp_enabled' => (bool) ($data['erp_enabled'] ?? false)]);

        $this->sendNotification(__('teams.notifications.save.success'));

        $this->js('window.location.reload()');
    }

    public function render(): View
    {
        return view('livewire.app.teams.update-erp-settings');
    }
}
