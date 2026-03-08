<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Models\AiSummary;
use App\Services\AI\RecordSummaryService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Throwable;

final class GenerateRecordSummaryAction extends Action
{
    public static function getDefaultName(): string
    {
        return 'generateSummary';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('resources.actions.ai_summary'))
            ->icon(Heroicon::Sparkles)
            ->color('gray')
            ->modalHeading(__('resources.actions.ai_summary'))
            ->modalDescription(fn (Model $record): string => __('resources.notifications.ai_summary_description', ['model' => class_basename($record)]))
            ->modalSubmitAction(false)
            ->modalCancelActionLabel(__('resources.actions.close'))
            ->modalContent(fn (Model $record): View => $this->getSummaryView($record))
            ->registerModalActions([
                $this->makeRegenerateAction(),
                $this->makeCopyAction(),
            ]);
    }

    private function makeRegenerateAction(): Action
    {
        return Action::make('regenerate')
            ->label(__('resources.actions.regenerate'))
            ->icon(Heroicon::ArrowPath)
            ->color('gray')
            ->action(fn (Model $record) => $this->regenerateSummary($record));
    }

    private function makeCopyAction(): Action
    {
        return Action::make('copy')
            ->label(__('resources.actions.copy'))
            ->icon(Heroicon::Clipboard)
            ->color('gray')
            ->extraAttributes(function (Model $record): array {
                // @phpstan-ignore nullsafe.neverNull (defensive code for models without HasAiSummary trait)
                $summaryText = $this->getCachedSummary($record)?->summary ?? '';

                return [
                    'x-on:click' => 'window.navigator.clipboard.writeText('.json_encode($summaryText).'); $tooltip('.json_encode(__('resources.notifications.copied')).')',
                ];
            });
    }

    private function getSummaryView(Model $record): View
    {
        return view('filament.actions.ai-summary', [
            'summary' => $this->summaryService()->getSummary($record),
        ]);
    }

    private function getCachedSummary(Model $record): ?AiSummary
    {
        if (! method_exists($record, 'aiSummary')) {
            return null;
        }

        return $record->aiSummary; // @phpstan-ignore property.notFound
    }

    private function regenerateSummary(Model $record): void
    {
        try {
            $this->summaryService()->getSummary($record, regenerate: true);

            Notification::make()
                ->title(__('resources.notifications.summary_regenerated'))
                ->success()
                ->send();
        } catch (Throwable $e) {
            Notification::make()
                ->title(__('resources.notifications.summary_failed'))
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    private function summaryService(): RecordSummaryService
    {
        return resolve(RecordSummaryService::class);
    }
}
