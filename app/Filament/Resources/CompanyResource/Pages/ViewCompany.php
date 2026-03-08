<?php

declare(strict_types=1);

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Actions\ComposeEmailAction;
use App\Filament\Actions\GenerateRecordSummaryAction;
use App\Filament\Components\Infolists\ActivityTimeline;
use App\Filament\Components\Infolists\EmailThread;
use App\Filament\Components\Infolists\AvatarName;
use App\Filament\Resources\CompanyResource;
use App\Filament\Resources\CompanyResource\RelationManagers\NotesRelationManager;
use App\Filament\Resources\CompanyResource\RelationManagers\PeopleRelationManager;
use App\Filament\Resources\CompanyResource\RelationManagers\InvoicesRelationManager;
use App\Filament\Resources\CompanyResource\RelationManagers\QuotesRelationManager;
use App\Filament\Resources\CompanyResource\RelationManagers\TasksRelationManager;
use App\Models\Company;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Relaticle\CustomFields\Facades\CustomFields;

final class ViewCompany extends ViewRecord
{
    protected static string $resource = CompanyResource::class;

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
                        ->action(function (Company $record): void {
                            $url = CompanyResource::getUrl('view', [$record]);
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
                        ->action(function (Company $record): void {
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
        return $schema
            ->schema([
                Flex::make([
                    Section::make([
                        Flex::make([
                            AvatarName::make('logo')
                                ->avatar('logo')
                                ->name('name')
                                ->avatarSize('lg')
                                ->textSize('xl')
                                ->square()
                                ->label(''),
                            AvatarName::make('creator')
                                ->avatar('creator.avatar')
                                ->name('creator.name')
                                ->avatarSize('sm')
                                ->textSize('sm')  // Default text size for creator
                                ->circular()
                                ->label(__('resources.columns.created_by')),
                            AvatarName::make('accountOwner')
                                ->avatar('accountOwner.avatar')
                                ->name('accountOwner.name')
                                ->avatarSize('sm')
                                ->textSize('sm')  // Default text size for account owner
                                ->circular()
                                ->label(__('resources.columns.account_owner')),
                        ]),
                        CustomFields::infolist()->forSchema($schema)->build(),
                    ]),
                    Section::make([
                        TextEntry::make('created_at')
                            ->label(__('resources.columns.created_date'))
                            ->icon('heroicon-o-clock')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->label(__('resources.columns.last_updated'))
                            ->icon('heroicon-o-clock')
                            ->dateTime(),
                    ])->grow(false),
                ])->columnSpan('full'),
                Section::make(__('emails.thread'))
                    ->schema([
                        EmailThread::make('emails')->label(''),
                    ])
                    ->columnSpan('full'),
                Section::make(__('activities.timeline'))
                    ->schema([
                        ActivityTimeline::make('activities')->label(''),
                    ])
                    ->columnSpan('full'),
            ]);
    }

    public function getRelationManagers(): array
    {
        return [
            PeopleRelationManager::class,
            QuotesRelationManager::class,
            InvoicesRelationManager::class,
            TasksRelationManager::class,
            NotesRelationManager::class,
        ];
    }
}
