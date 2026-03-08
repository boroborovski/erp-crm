<?php

declare(strict_types=1);

namespace App\Filament\Resources\PeopleResource\Pages;

use App\Filament\Actions\ComposeEmailAction;
use App\Filament\Actions\GenerateRecordSummaryAction;
use App\Filament\Components\Infolists\ActivityTimeline;
use App\Filament\Components\Infolists\EmailThread;
use App\Filament\Resources\CompanyResource;
use App\Filament\Resources\PeopleResource;
use App\Models\People;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Relaticle\CustomFields\Facades\CustomFields;

final class ViewPeople extends ViewRecord
{
    protected static string $resource = PeopleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ComposeEmailAction::make(),
            GenerateRecordSummaryAction::make(),
            EditAction::make()->icon('heroicon-o-pencil-square')->label(__('resources.actions.edit')),
            ActionGroup::make([
                ActionGroup::make([
                    Action::make('copyPageUrl')
                        ->label(__('resources.actions.copy_page_url'))
                        ->icon('heroicon-o-clipboard-document')
                        ->action(function (People $record): void {
                            $url = PeopleResource::getUrl('view', [$record]);
                            $title = __('resources.notifications.url_copied');
                            $this->js("
                            navigator.clipboard.writeText('{$url}').then(() => {
                                new FilamentNotification()
                                    .title('{$title}')
                                    .success()
                                    .send()
                            })
                        ");
                        }),
                    Action::make('copyRecordId')
                        ->label(__('resources.actions.copy_record_id'))
                        ->icon('heroicon-o-clipboard-document')
                        ->action(function (People $record): void {
                            $id = $record->getKey();
                            $title = __('resources.notifications.record_id_copied');
                            $this->js("
                            navigator.clipboard.writeText('{$id}').then(() => {
                                new FilamentNotification()
                                    .title('{$title}')
                                    .success()
                                    .send()
                            })
                        ");
                        }),
                ])->dropdown(false),
                DeleteAction::make(),
            ]),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                Flex::make([
                    ImageEntry::make('avatar')
                        ->label('')
                        ->height(30)
                        ->circular()
                        ->grow(false),
                    TextEntry::make('name')
                        ->label('')
                        ->size(TextSize::Large),
                    TextEntry::make('company.name')
                        ->label(__('resources.columns.company'))
                        ->color('primary')
                        ->url(fn (People $record): ?string => $record->company ? CompanyResource::getUrl('view', [$record->company]) : null),
                ]),
                CustomFields::infolist()->forSchema($schema)->build()->columnSpanFull(),
            ])->columnSpanFull(),
            Section::make(__('emails.thread'))
                ->schema([
                    EmailThread::make('emails')->label(''),
                ])
                ->columnSpanFull(),
            Section::make(__('activities.timeline'))
                ->schema([
                    ActivityTimeline::make('activities')->label(''),
                ])
                ->columnSpanFull(),
        ]);
    }
}
