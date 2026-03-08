@php
    $record = $getRecord();
    $emails = collect();

    if ($record !== null && method_exists($record, 'emails')) {
        $emails = $record->emails()->limit(50)->get();
    }
@endphp

<div class="space-y-2">
    @forelse ($emails as $email)
        @php
            $isOutbound = $email->direction->value === 'outbound';
            $label = $isOutbound ? __('emails.direction.outbound') : __('emails.direction.inbound');
            $labelColor = $isOutbound ? 'text-primary-600 dark:text-primary-400' : 'text-gray-500 dark:text-gray-400';
            $toList = implode(', ', $email->to ?? []);
        @endphp

        <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 shadow-sm">
            {{-- Header --}}
            <div class="flex items-start justify-between gap-2">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                        {{ $email->subject }}
                    </p>
                    <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                        @if ($isOutbound)
                            {{ __('emails.fields.to') }}: {{ $toList }}
                        @else
                            {{ $email->from_name ? $email->from_name.' <'.$email->from_email.'>' : $email->from_email }}
                        @endif
                    </p>
                </div>
                <div class="flex shrink-0 items-center gap-2">
                    <span class="text-xs {{ $labelColor }}">{{ $label }}</span>
                    <span class="text-xs text-gray-400 dark:text-gray-500">
                        {{ $email->sent_at->diffForHumans() }}
                    </span>
                </div>
            </div>

            {{-- Body preview --}}
            @if ($email->body_text)
                <div class="mt-2 text-sm text-gray-700 dark:text-gray-300 line-clamp-3 whitespace-pre-line">
                    {{ mb_strimwidth(strip_tags($email->body_text), 0, 300, '…') }}
                </div>
            @endif
        </div>
    @empty
        <p class="text-sm text-gray-500 dark:text-gray-400 py-2">
            {{ __('emails.no_emails') }}
        </p>
    @endforelse
</div>
