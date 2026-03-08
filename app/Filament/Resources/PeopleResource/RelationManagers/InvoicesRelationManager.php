<?php

declare(strict_types=1);

namespace App\Filament\Resources\PeopleResource\RelationManagers;

use App\Filament\Resources\InvoiceResource;
use App\Models\Team;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Size;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

final class InvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'invoices';

    protected static string|\BackedEnum|null $icon = 'heroicon-o-document-currency-dollar';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        $tenant = Filament::getTenant();

        return $tenant instanceof Team && (bool) $tenant->erp_enabled;
    }

    public function form(Schema $schema): Schema
    {
        return InvoiceResource::form($schema);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('invoice_number')
            ->heading(__('invoices.navigation.label'))
            ->columns([
                TextColumn::make('invoice_number')
                    ->label(__('invoices.fields.invoice_number'))
                    ->searchable(),

                TextColumn::make('status')
                    ->label(__('invoices.fields.status'))
                    ->badge(),

                TextColumn::make('issue_date')
                    ->label(__('invoices.fields.issue_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('due_date')
                    ->label(__('invoices.fields.due_date'))
                    ->date()
                    ->placeholder('—'),

                TextColumn::make('created_at')
                    ->label(__('resources.columns.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()->icon('heroicon-o-plus')->size(Size::Small),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->url(fn (Model $record): string => InvoiceResource::getUrl('view', [$record])),
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
