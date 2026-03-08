<?php

declare(strict_types=1);

namespace App\Filament\Resources\QuoteResource\Pages;

use App\Enums\EmailDirection;
use App\Enums\InvoiceStatus;
use App\Enums\QuoteStatus;
use App\Filament\Resources\InvoiceResource;
use App\Filament\Resources\QuoteResource;
use App\Models\Email;
use App\Models\Invoice;
use App\Models\InvoiceLineItem;
use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Mail;
use Throwable;

final class ViewQuote extends ViewRecord
{
    protected static string $resource = QuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('send_quote')
                ->label(__('quotes.actions.send_quote'))
                ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->modalHeading(__('quotes.actions.send_quote'))
                ->modalSubmitActionLabel(__('quotes.actions.send_quote'))
                ->form([
                    TextInput::make('to')
                        ->label(__('emails.fields.to'))
                        ->email()
                        ->required()
                        ->default(fn (): string => $this->getDefaultRecipientEmail()),

                    TextInput::make('subject')
                        ->label(__('emails.fields.subject'))
                        ->required()
                        ->default(fn (): string => __('quotes.email.default_subject', [
                            'number' => $this->record->quote_number,
                            'team'   => $this->record->team->name,
                        ])),

                    RichEditor::make('body')
                        ->label(__('emails.fields.body'))
                        ->required()
                        ->default(fn (): string => __('quotes.email.default_body', [
                            'number' => $this->record->quote_number,
                            'team'   => $this->record->team->name,
                        ]))
                        ->toolbarButtons(['bold', 'italic', 'underline', 'link', 'bulletList', 'orderedList', 'redo', 'undo']),
                ])
                ->action(function (array $data): void {
                    /** @var Quote $record */
                    $record = $this->record;
                    $record->load(['lineItems.product', 'opportunity', 'company', 'contact', 'team']);

                    try {
                        $pdf      = Pdf::loadView('pdf.quote', ['quote' => $record]);
                        $pdfData  = $pdf->output();
                        $filename = 'quote-' . $record->quote_number . '.pdf';

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
                            'subject_type' => 'quote',
                            'subject_id'   => $record->getKey(),
                        ]);

                        if ($record->status === QuoteStatus::Draft) {
                            $record->update(['status' => QuoteStatus::Sent]);
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

            Action::make('download_pdf')
                ->label(__('quotes.actions.download_pdf'))
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function (): void {
                    /** @var Quote $record */
                    $record = $this->record;
                    $record->load(['lineItems.product', 'opportunity', 'company', 'contact', 'team']);

                    $pdf      = Pdf::loadView('pdf.quote', ['quote' => $record]);
                    $base64   = base64_encode($pdf->output());
                    $filename = 'quote-' . $record->quote_number . '.pdf';

                    $this->js("(function(){const a=document.createElement('a');a.href='data:application/pdf;base64,{$base64}';a.download='{$filename}';document.body.appendChild(a);a.click();document.body.removeChild(a);})();");
                }),

            Action::make('convert_to_invoice')
                ->label(__('invoices.actions.convert_to_invoice'))
                ->icon('heroicon-o-document-currency-dollar')
                ->color('warning')
                ->requiresConfirmation()
                ->visible(fn (): bool => $this->record->status === QuoteStatus::Accepted && $this->record->invoice === null)
                ->action(function (): void {
                    /** @var Quote $quote */
                    $quote = $this->record;
                    $quote->load('lineItems');

                    $invoice = Invoice::query()->create([
                        'team_id'    => $quote->team_id,
                        'quote_id'   => $quote->getKey(),
                        'company_id' => $quote->company_id,
                        'contact_id' => $quote->contact_id,
                        'status'     => InvoiceStatus::Draft,
                        'issue_date' => now()->toDateString(),
                        'notes'      => $quote->notes,
                    ]);

                    foreach ($quote->lineItems as $index => $item) {
                        InvoiceLineItem::query()->create([
                            'invoice_id'   => $invoice->getKey(),
                            'product_id'   => $item->product_id,
                            'description'  => $item->description,
                            'quantity'     => $item->quantity,
                            'unit_price'   => $item->unit_price,
                            'discount_pct' => $item->discount_pct,
                            'tax_pct'      => $item->tax_pct,
                            'sort_order'   => $index,
                        ]);
                    }

                    $this->redirect(InvoiceResource::getUrl('view', [$invoice]));
                }),

            EditAction::make()->icon('heroicon-o-pencil-square')->label(__('resources.actions.edit')),
            DeleteAction::make(),
        ];
    }

    private function getDefaultRecipientEmail(): string
    {
        /** @var Quote $record */
        $record = $this->record;

        // Try contact's email custom field first
        if ($record->contact !== null) {
            $contact = $record->contact->load('customFieldValues.customField');
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

        // Try first person linked to the company
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
            Section::make(__('quotes.sections.details'))->columnSpanFull()->schema([
                TextEntry::make('quote_number')
                    ->label(__('quotes.fields.quote_number')),

                TextEntry::make('status')
                    ->label(__('quotes.fields.status'))
                    ->badge(),

                TextEntry::make('opportunity.name')
                    ->label(__('quotes.fields.opportunity'))
                    ->placeholder('—'),

                TextEntry::make('company.name')
                    ->label(__('quotes.fields.company'))
                    ->placeholder('—'),

                TextEntry::make('contact.name')
                    ->label(__('quotes.fields.contact'))
                    ->placeholder('—'),

                TextEntry::make('valid_until')
                    ->label(__('quotes.fields.valid_until'))
                    ->date()
                    ->placeholder('—'),
            ])->columns(3),

            Section::make(__('quotes.sections.line_items'))->columnSpanFull()->schema([
                RepeatableEntry::make('lineItems')
                    ->label('')
                    ->schema([
                        TextEntry::make('description')
                            ->label(__('quotes.fields.description'))
                            ->columnSpan(4),

                        TextEntry::make('quantity')
                            ->label(__('quotes.fields.quantity'))
                            ->numeric(decimalPlaces: 2)
                            ->columnSpan(1),

                        TextEntry::make('unit_price')
                            ->label(__('quotes.fields.unit_price'))
                            ->numeric(decimalPlaces: 2)
                            ->prefix('$')
                            ->columnSpan(2),

                        TextEntry::make('discount_pct')
                            ->label(__('quotes.fields.discount_pct'))
                            ->numeric(decimalPlaces: 2)
                            ->suffix('%')
                            ->columnSpan(2),

                        TextEntry::make('tax_pct')
                            ->label(__('quotes.fields.tax_pct'))
                            ->numeric(decimalPlaces: 2)
                            ->suffix('%')
                            ->columnSpan(1),

                        TextEntry::make('total')
                            ->label(__('quotes.fields.line_total'))
                            ->getStateUsing(fn (object $record): string => number_format((float) $record->total, 2))
                            ->prefix('$')
                            ->columnSpan(2),
                    ])
                    ->columns(12),

                TextEntry::make('subtotal')
                    ->label(__('quotes.fields.subtotal'))
                    ->getStateUsing(fn (Quote $record): string => number_format($record->subtotal, 2))
                    ->prefix('$'),

                TextEntry::make('total_tax')
                    ->label(__('quotes.fields.total_tax'))
                    ->getStateUsing(fn (Quote $record): string => number_format($record->total_tax, 2))
                    ->prefix('$'),

                TextEntry::make('grand_total')
                    ->label(__('quotes.fields.grand_total'))
                    ->getStateUsing(fn (Quote $record): string => number_format($record->grand_total, 2))
                    ->prefix('$')
                    ->weight('bold'),
            ]),

            Section::make(__('quotes.sections.notes'))->columnSpanFull()->schema([
                TextEntry::make('notes')
                    ->label(__('quotes.fields.notes'))
                    ->placeholder('—')
                    ->columnSpanFull(),
            ])->visible(fn (): bool => filled($this->record->notes)),
        ]);
    }
}
