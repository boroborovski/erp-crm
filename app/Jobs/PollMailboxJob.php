<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\EmailDirection;
use App\Models\Email;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class PollMailboxJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle(): void
    {
        if (! extension_loaded('imap')) {
            return;
        }

        $host = config('services.imap.host');
        if (blank($host)) {
            return;
        }

        $port = (int) config('services.imap.port', 993);
        $encryption = config('services.imap.encryption', 'ssl');
        $username = (string) config('services.imap.username');
        $password = (string) config('services.imap.password');
        $teamId = config('services.imap.team_id');

        $encryptionFlag = match ($encryption) {
            'ssl' => '/ssl',
            'tls' => '/tls',
            default => '/novalidate-cert',
        };

        $mailbox = sprintf('{%s:%d/imap%s}INBOX', $host, $port, $encryptionFlag);

        /** @var resource|false $connection */
        $connection = @imap_open($mailbox, $username, $password);

        if ($connection === false) {
            Log::warning('PollMailboxJob: failed to connect to IMAP server', ['host' => $host]);

            return;
        }

        try {
            /** @var list<int>|false $unseen */
            $unseen = imap_search($connection, 'UNSEEN');

            if ($unseen === false) {
                return;
            }

            foreach ($unseen as $msgNum) {
                $this->processMessage($connection, $msgNum, $teamId);
            }
        } finally {
            imap_close($connection);
        }
    }

    /**
     * @param  resource  $connection
     */
    private function processMessage($connection, int $msgNum, mixed $teamId): void
    {
        /** @var \stdClass|false $header */
        $header = imap_headerinfo($connection, $msgNum);

        if ($header === false) {
            return;
        }

        $messageId = isset($header->message_id) ? trim((string) $header->message_id) : null;

        if ($messageId !== null && Email::query()->where('message_id', $messageId)->exists()) {
            return;
        }

        $fromEmail = isset($header->from[0]->mailbox, $header->from[0]->host)
            ? $header->from[0]->mailbox.'@'.$header->from[0]->host
            : null;

        if ($fromEmail === null) {
            return;
        }

        $fromName = isset($header->from[0]->personal)
            ? imap_utf8((string) $header->from[0]->personal)
            : null;

        $subject = isset($header->subject)
            ? imap_utf8((string) $header->subject)
            : '(no subject)';

        $inReplyTo = isset($header->in_reply_to) ? trim((string) $header->in_reply_to) : null;

        $to = [];
        foreach ($header->to ?? [] as $toAddr) {
            if (isset($toAddr->mailbox, $toAddr->host)) {
                $to[] = $toAddr->mailbox.'@'.$toAddr->host;
            }
        }

        $sentAt = isset($header->date)
            ? Carbon::parse((string) $header->date)
            : now();

        /** @var \stdClass|false $structure */
        $structure = imap_fetchstructure($connection, $msgNum);
        [$bodyText, $bodyHtml] = $this->extractBody($connection, $msgNum, $structure);

        $resolvedTeamId = $teamId ?? $this->resolveTeamId($fromEmail, $to);

        if ($resolvedTeamId === null) {
            return;
        }

        [$subjectType, $subjectId] = $this->resolveSubject((string) $resolvedTeamId, $fromEmail);

        Email::query()->create([
            'team_id' => $resolvedTeamId,
            'direction' => EmailDirection::Inbound,
            'message_id' => $messageId,
            'in_reply_to' => $inReplyTo,
            'from_email' => $fromEmail,
            'from_name' => $fromName,
            'to' => $to,
            'subject' => $subject,
            'body_html' => $bodyHtml,
            'body_text' => $bodyText ?? '',
            'sent_at' => $sentAt,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
        ]);

        imap_setflag_full($connection, (string) $msgNum, '\\Seen');
    }

    /**
     * @param  resource  $connection
     * @param  \stdClass|false  $structure
     * @return array{string|null, string|null}
     */
    private function extractBody($connection, int $msgNum, $structure): array
    {
        if ($structure === false) {
            $raw = imap_body($connection, $msgNum) ?: '';

            return [$raw, null];
        }

        $bodyText = null;
        $bodyHtml = null;

        if (isset($structure->parts)) {
            foreach ($structure->parts as $partNum => $part) {
                $encoding = $part->encoding ?? 0;
                $raw = imap_fetchbody($connection, $msgNum, (string) ($partNum + 1));

                $decoded = match ($encoding) {
                    3 => base64_decode($raw),
                    4 => quoted_printable_decode($raw),
                    default => $raw,
                };

                if ($part->subtype === 'HTML') {
                    $bodyHtml = $decoded;
                } elseif ($part->subtype === 'PLAIN') {
                    $bodyText = $decoded;
                }
            }
        } else {
            $raw = imap_body($connection, $msgNum) ?: '';
            $encoding = $structure->encoding ?? 0;

            $decoded = match ($encoding) {
                3 => base64_decode($raw),
                4 => quoted_printable_decode($raw),
                default => $raw,
            };

            if ($structure->subtype === 'HTML') {
                $bodyHtml = $decoded;
            } else {
                $bodyText = $decoded;
            }
        }

        return [$bodyText, $bodyHtml];
    }

    /**
     * Try to match inbound email to a People record's email custom field.
     *
     * @return array{string|null, string|null}
     */
    private function resolveSubject(string $teamId, string $fromEmail): array
    {
        $cfValuesTable = config('custom-fields.database.table_names.custom_field_values', 'custom_field_values');
        $cfTable = config('custom-fields.database.table_names.custom_fields', 'custom_fields');

        $match = DB::table($cfValuesTable)
            ->join($cfTable, "{$cfTable}.id", '=', "{$cfValuesTable}.custom_field_id")
            ->where("{$cfTable}.code", 'emails')
            ->where("{$cfValuesTable}.entity_type", 'people')
            ->where("{$cfValuesTable}.team_id", $teamId)
            ->whereJsonContains("{$cfValuesTable}.json_value", $fromEmail)
            ->select("{$cfValuesTable}.entity_id")
            ->first();

        if ($match !== null) {
            return ['people', $match->entity_id];
        }

        return [null, null];
    }

    /**
     * Attempt to determine the team from the recipient addresses.
     * Falls back to the first team in the database.
     *
     * @param  list<string>  $to
     */
    private function resolveTeamId(string $fromEmail, array $to): mixed
    {
        $cfValuesTable = config('custom-fields.database.table_names.custom_field_values', 'custom_field_values');
        $cfTable = config('custom-fields.database.table_names.custom_fields', 'custom_fields');

        $match = DB::table($cfValuesTable)
            ->join($cfTable, "{$cfTable}.id", '=', "{$cfValuesTable}.custom_field_id")
            ->where("{$cfTable}.code", 'emails')
            ->whereJsonContains("{$cfValuesTable}.json_value", $fromEmail)
            ->select("{$cfValuesTable}.team_id")
            ->first();

        if ($match !== null) {
            return $match->team_id;
        }

        return DB::table('teams')->value('id');
    }
}
