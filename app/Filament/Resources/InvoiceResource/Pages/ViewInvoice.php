<?php

declare(strict_types=1);

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Enums\EmailDirection;
use App\Enums\InvoiceStatus;
use App\Enums\PaymentMethod;
use App\Filament\Resources\InvoiceResource;
use App\Models\Email;
use App\Models\Invoice;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Mail;
use Throwable;

final class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('send_invoice')
                ->label(__('invoices.actions.send_invoice'))
                ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->modalHeading(__('invoices.actions.send_invoice'))
                ->modalSubmitActionLabel(__('invoices.actions.send_invoice'))
                ->form([
                    TextInput::make('to')
                        ->label(__('emails.fields.to'))
                        ->email()
                        ->required()
                        ->default(fn (): string => $this->getDefaultRecipientEmail()),

                    TextInput::make('subject')
                        ->label(__('emails.fields.subject'))
                        ->required()
                        ->default(fn (): string => __('invoices.email.default_subject', [
                            'number' => $this->record->invoice_number,
                            'team'   => $this->record->team->name,
                        ])),

                    RichEditor::make('body')
                        ->label(__('emails.fields.body'))
                        ->required()
                        ->default(fn (): string => __('invoices.email.default_body', [
                            'number' => $this->record->invoice_number,
                            'team'   => $this->record->team->name,
                        ]))
                        ->toolbarButtons(['bold', 'italic', 'underline', 'link', 'bulletList', 'orderedList', 'redo', 'undo']),
                ])
                ->action(function (array $data): void {
                    /** @var Invoice $record */
                    $record = $this->record;
                    $record->load(['lineItems.product', 'quote', 'company', 'contact', 'team', 'payments']);

                    try {
                        $pdf      = Pdf::loadView('pdf.invoice', ['invoice' => $record]);
                        $pdfData  = $pdf->output();
                        $filename = 'invoice-' . $record->invoice_number . '.pdf';

                        Mail::html($data['body'], function (\Illuminate\Mail\Message $message) use ($data, $pdfData, $filename): void {
                            $message
                                ->to($data['to'])
                                ->subject($data['subject'])
                                ->attachData($pdfData, $filename, ['mime' => 'application/pdf']);
                        });

                        $messageId = sprintf('<%s@%s>', uniqid('', true), parse_url((string) config('app.url'), PHP_URL_HOST) ?? 'localhost');

                        Email::query()->create([
                            'team_id'      => $record->team_id,
                            'direction'    => EmailDirection::Outbound,
                            'message_id'   => $messageId,
                            'from_email'   => (string) config('mail.from.address', ''),
                            'from_name'    => (string) config('mail.from.name', ''),
                            'to'           => [$data['to']],
                            'subject'      => $data['subject'],
                            'body_html'    => $data['body'],
                            'body_text'    => strip_tags($data['body']),
                            'sent_at'      => now(),
                            'subject_type' => 'invoice',
                            'subject_id'   => $record->getKey(),
                        ]);

                        if ($record->status === InvoiceStatus::Draft) {
                            $record->update(['status' => InvoiceStatus::Issued]);
                        }

                        Notification::make()
                            ->title(__('emails.notifications.sent'))
                            ->success()
                            ->send();

                        $this->redirect($this->getUrl(), navigate: true);
                    } catch (Throwable $e) {
                        Notification::make()
                            ->title(__('emails.notifications.send_failed'))
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Action::make('record_payment')
                ->label(__('invoices.actions.record_payment'))
                ->icon('heroicon-o-banknotes')
                ->color('success')
                ->modalHeading(__('invoices.actions.record_payment'))
                ->modalSubmitActionLabel(__('invoices.actions.record_payment'))
                ->visible(fn (): bool => ! in_array($this->record->status, [InvoiceStatus::Paid, InvoiceStatus::Void], true))
                ->form([
                    TextInput::make('amount')
                        ->label(__('invoices.fields.amount'))
                        ->numeric()
                        ->required()
                        ->minValue(0.0001)
                        ->default(fn (): float => $this->record->load('lineItems', 'payments')->amount_outstanding),

                    DateTimePicker::make('paid_at')
                        ->label(__('invoices.fields.paid_at'))
                        ->required()
                        ->default(now()),

                    Select::make('method')
                        ->label(__('invoices.fields.method'))
                        ->options(PaymentMethod::class)
                        ->required()
                        ->default(PaymentMethod::Bank->value),

                    TextInput::make('reference')
                        ->label(__('invoices.fields.reference'))
                        ->nullable()
                        ->maxLength(255),

                    Textarea::make('notes')
                        ->label(__('invoices.fields.notes'))
                        ->nullable()
                        ->rows(2),
                ])
                ->action(function (array $data): void {
                    /** @var Invoice $record */
                    $record = $this->record;

                    Payment::query()->create([
                        'invoice_id' => $record->getKey(),
                        'amount'     => $data['amount'],
                        'paid_at'    => $data['paid_at'],
                        'method'     => $data['method'],
                        'reference'  => $data['reference'] ?? null,
                        'notes'      => $data['notes'] ?? null,
                    ]);

                    $record->load('lineItems', 'payments');
                    $record->recalculateStatus();

                    Notification::make()
                        ->title(__('invoices.actions.record_payment'))
                        ->success()
                        ->send();

                    $this->redirect($this->getUrl(), navigate: true);
                }),

            Action::make('void_invoice')
                ->label(__('invoices.actions.void_invoice'))
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->modalDescription(__('invoices.actions.void_confirm'))
                ->visible(fn (): bool => $this->record->status !== InvoiceStatus::Void)
                ->action(function (): void {
                    $this->record->update(['status' => InvoiceStatus::Void]);

                    Notification::make()
                        ->title(__('invoices.actions.void_invoice'))
                        ->success()
                        ->send();

                    $this->redirect($this->getUrl(), navigate: true);
                }),

            Action::make('download_pdf')
                ->label(__('invoices.actions.download_pdf'))
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function (): void {
                    /** @var Invoice $record */
                    $record = $this->record;
                    $record->load(['lineItems.product', 'quote', 'company', 'contact', 'team', 'payments']);

                    $pdf      = Pdf::loadView('pdf.invoice', ['invoice' => $record]);
                    $base64   = base64_encode($pdf->output());
                    $filename = 'invoice-' . $record->invoice_number . '.pdf';

                    $this->js("(function(){const a=document.createElement('a');a.href='data:application/pdf;base64,{$base64}';a.download='{$filename}';document.body.appendChild(a);a.click();document.body.removeChild(a);})();");
                }),

            EditAction::make()->icon('heroicon-o-pencil-square')->label(__('resources.actions.edit')),
            DeleteAction::make(),
        ];
    }

    private function getDefaultRecipientEmail(): string
    {
        /** @var Invoice $record */
        $record = $this->record;

        if ($record->contact !== null) {
            $contact    = $record->contact->load('customFieldValues.customField');
            $emailValue = $contact->customFieldValues
                ->first(fn ($v) => $v->customField?->code === 'emails');

            if ($emailValue !== null) {
                $json = $emailValue->json_value;

                if (is_array($json) && isset($json[0])) {
                    return (string) $json[0];
                }

                if (is_string($json) && $json !== '') {
                    return $json;
                }
            }
        }

        if ($record->company !== null) {
            $person = $record->company->people()
                ->with('customFieldValues.customField')
                ->first();

            if ($person !== null) {
                $emailValue = $person->customFieldValues
                    ->first(fn ($v) => $v->customField?->code === 'emails');

                if ($emailValue !== null) {
                    $json = $emailValue->json_value;

                    if (is_array($json) && isset($json[0])) {
                        return (string) $json[0];
                    }

                    if (is_string($json) && $json !== '') {
                        return $json;
                    }
                }
            }
        }

        return '';
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make(__('invoices.sections.details'))->columnSpanFull()->schema([
                TextEntry::make('invoice_number')
                    ->label(__('invoices.fields.invoice_number')),

                TextEntry::make('status')
                    ->label(__('invoices.fields.status'))
                    ->badge(),

                TextEntry::make('quote.quote_number')
                    ->label(__('invoices.fields.quote'))
                    ->placeholder('—'),

                TextEntry::make('company.name')
                    ->label(__('invoices.fields.company'))
                    ->placeholder('—'),

                TextEntry::make('contact.name')
                    ->label(__('invoices.fields.contact'))
                    ->placeholder('—'),

                TextEntry::make('issue_date')
                    ->label(__('invoices.fields.issue_date'))
                    ->date(),

                TextEntry::make('due_date')
                    ->label(__('invoices.fields.due_date'))
                    ->date()
                    ->placeholder('—'),
            ])->columns(3),

            Section::make(__('invoices.sections.line_items'))->columnSpanFull()->schema([
                RepeatableEntry::make('lineItems')
                    ->label('')
                    ->schema([
                        TextEntry::make('description')
                            ->label(__('invoices.fields.description'))
                            ->columnSpan(4),

                        TextEntry::make('quantity')
                            ->label(__('invoices.fields.quantity'))
                            ->numeric(decimalPlaces: 2)
                            ->columnSpan(1),

                        TextEntry::make('unit_price')
                            ->label(__('invoices.fields.unit_price'))
                            ->numeric(decimalPlaces: 2)
                            ->prefix('$')
                            ->columnSpan(2),

                        TextEntry::make('discount_pct')
                            ->label(__('invoices.fields.discount_pct'))
                            ->numeric(decimalPlaces: 2)
                            ->suffix('%')
                            ->columnSpan(2),

                        TextEntry::make('tax_pct')
                            ->label(__('invoices.fields.tax_pct'))
                            ->numeric(decimalPlaces: 2)
                            ->suffix('%')
                            ->columnSpan(1),

                        TextEntry::make('total')
                            ->label(__('invoices.fields.line_total'))
                            ->getStateUsing(fn (object $record): string => number_format((float) $record->total, 2))
                            ->prefix('$')
                            ->columnSpan(2),
                    ])
                    ->columns(12),

                TextEntry::make('subtotal')
                    ->label(__('invoices.fields.subtotal'))
                    ->getStateUsing(fn (Invoice $record): string => number_format($record->subtotal, 2))
                    ->prefix('$'),

                TextEntry::make('total_tax')
                    ->label(__('invoices.fields.total_tax'))
                    ->getStateUsing(fn (Invoice $record): string => number_format($record->total_tax, 2))
                    ->prefix('$'),

                TextEntry::make('grand_total')
                    ->label(__('invoices.fields.grand_total'))
                    ->getStateUsing(fn (Invoice $record): string => number_format($record->grand_total, 2))
                    ->prefix('$')
                    ->weight('bold'),

                TextEntry::make('amount_paid')
                    ->label(__('invoices.fields.amount_paid'))
                    ->getStateUsing(fn (Invoice $record): string => number_format($record->amount_paid, 2))
                    ->prefix('$')
                    ->color('success'),

                TextEntry::make('amount_outstanding')
                    ->label(__('invoices.fields.amount_outstanding'))
                    ->getStateUsing(fn (Invoice $record): string => number_format($record->amount_outstanding, 2))
                    ->prefix('$')
                    ->color(fn (Invoice $record): string => $record->amount_outstanding > 0 ? 'danger' : 'success'),
            ]),

            Section::make(__('invoices.sections.payments'))
                ->columnSpanFull()
                ->schema([
                    RepeatableEntry::make('payments')
                        ->label('')
                        ->schema([
                            TextEntry::make('paid_at')
                                ->label(__('invoices.fields.paid_at'))
                                ->dateTime(),

                            TextEntry::make('amount')
                                ->label(__('invoices.fields.amount'))
                                ->numeric(decimalPlaces: 2)
                                ->prefix('$'),

                            TextEntry::make('method')
                                ->label(__('invoices.fields.method'))
                                ->badge(),

                            TextEntry::make('reference')
                                ->label(__('invoices.fields.reference'))
                                ->placeholder('—'),
                        ])
                        ->columns(4),
                ])
                ->visible(fn (): bool => $this->record->payments->isNotEmpty()),

            Section::make(__('invoices.sections.notes'))->columnSpanFull()->schema([
                TextEntry::make('notes')
                    ->label(__('invoices.fields.notes'))
                    ->placeholder('—')
                    ->columnSpanFull(),
            ])->visible(fn (): bool => filled($this->record->notes)),
        ]);
    }
}
