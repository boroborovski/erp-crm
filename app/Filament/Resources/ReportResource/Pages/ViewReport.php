<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Components\Infolists\ReportResults;
use App\Filament\Resources\ReportResource;
use App\Models\Report;
use App\Services\ReportRunner;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

final class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->icon('heroicon-o-pencil-square')->label(__('resources.actions.edit')),
            \Filament\Actions\Action::make('export')
                ->label(__('reports.actions.export_csv'))
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function (Report $record): void {
                    $runner = app(ReportRunner::class);
                    $results = $runner->run($record);
                    $columns = $record->columns ?? [];
                    $columnLabels = $record->entity->getAvailableColumns();
                    $rows = $runner->toRows($results, $columns);

                    $lines = [];
                    $headers = array_map(fn (string $col): string => $columnLabels[$col] ?? $col, $columns);
                    $lines[] = collect($headers)
                        ->map(fn (string $h): string => '"' . str_replace('"', '""', $h) . '"')
                        ->implode(',');

                    foreach ($rows as $row) {
                        $lines[] = collect($row)
                            ->map(fn ($v): string => '"' . str_replace('"', '""', (string) ($v ?? '')) . '"')
                            ->implode(',');
                    }

                    $csv = implode("\n", $lines);
                    $base64 = base64_encode($csv);
                    $filename = Str::slug($record->name) . '.csv';

                    $this->js("(function(){const a=document.createElement('a');a.href='data:text/csv;charset=utf-8;base64,{$base64}';a.download='{$filename}';document.body.appendChild(a);a.click();document.body.removeChild(a);})();");
                }),
            DeleteAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                TextEntry::make('name')
                    ->label(__('reports.builder.fields.name')),
                TextEntry::make('entity')
                    ->label(__('reports.builder.fields.entity'))
                    ->formatStateUsing(fn ($state): string => $state->getLabel())
                    ->badge()
                    ->color('primary'),
                TextEntry::make('description')
                    ->label(__('reports.builder.fields.description'))
                    ->placeholder('—')
                    ->columnSpanFull(),
            ])->columns(2)->columnSpanFull(),

            Section::make(__('reports.results.heading'))->schema([
                ReportResults::make('results')->label(''),
            ])->columnSpanFull(),
        ]);
    }
}
