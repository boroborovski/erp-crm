<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Enums\ActivityEvent;
use App\Enums\EmailDirection;
use App\Models\Email;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Throwable;

final class ComposeEmailAction extends Action
{
    public static function getDefaultName(): string
    {
        return 'composeEmail';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('emails.compose'))
            ->icon(Heroicon::OutlinedEnvelope)
            ->color('gray')
            ->modalHeading(__('emails.compose'))
            ->modalSubmitActionLabel(__('emails.send'))
            ->form([
                TextInput::make('to')
                    ->label(__('emails.fields.to'))
                    ->email()
                    ->required()
                    ->default(fn (Model $record): string => $this->getDefaultRecipient($record)),
                TextInput::make('subject')
                    ->label(__('emails.fields.subject'))
                    ->required()
                    ->maxLength(255),
                RichEditor::make('body')
                    ->label(__('emails.fields.body'))
                    ->required()
                    ->toolbarButtons(['bold', 'italic', 'underline', 'strike', 'link', 'bulletList', 'orderedList', 'redo', 'undo']),
            ])
            ->action(fn (array $data, Model $record) => $this->sendEmail($data, $record));
    }

    private function sendEmail(array $data, Model $record): void
    {
        try {
            $to = $data['to'];
            $subject = $data['subject'];
            $body = $data['body'];

            Mail::html($body, function (\Illuminate\Mail\Message $message) use ($to, $subject): void {
                $message->to($to)->subject($subject);
            });

            $messageId = sprintf('<%s@%s>', uniqid('', true), parse_url((string) config('app.url'), PHP_URL_HOST) ?? 'localhost');

            Email::query()->create([
                'team_id' => $record->team_id,
                'direction' => EmailDirection::Outbound,
                'message_id' => $messageId,
                'from_email' => (string) config('mail.from.address', ''),
                'from_name' => (string) config('mail.from.name', ''),
                'to' => [$to],
                'subject' => $subject,
                'body_html' => $body,
                'body_text' => strip_tags($body),
                'sent_at' => now(),
                'subject_type' => $record->getMorphClass(),
                'subject_id' => $record->getKey(),
            ]);

            if (method_exists($record, 'recordActivity')) {
                $record->recordActivity(ActivityEvent::EmailSent, $subject);
            }

            Notification::make()
                ->title(__('emails.notifications.sent'))
                ->success()
                ->send();
        } catch (Throwable $e) {
            Notification::make()
                ->title(__('emails.notifications.send_failed'))
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    private function getDefaultRecipient(Model $record): string
    {
        if (! method_exists($record, 'customFieldValues')) {
            return '';
        }

        $emailValue = $record->customFieldValues
            ->first(fn ($v) => $v->customField?->code === 'emails');

        if ($emailValue === null) {
            return '';
        }

        $json = $emailValue->json_value;

        if (is_array($json) && isset($json[0])) {
            return (string) $json[0];
        }

        return is_string($json) ? $json : '';
    }
}
