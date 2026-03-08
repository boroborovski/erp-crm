@php
    $record = $getRecord();
    $activities = collect();

    if ($record !== null && method_exists($record, 'activities')) {
        $activities = $record->activities()->with('causer')->limit(50)->get();
    }
@endphp

<div class="space-y-1">
    @forelse ($activities as $activity)
        @php
            $causer = $activity->causer;
            $avatar = $causer?->profile_photo_url ?? null;
            $actorName = $causer?->name ?? __('activities.unknown_actor');
            $eventLabel = $activity->event->label();
            $description = $activity->description;
        @endphp

        <div class="flex items-start gap-3 py-2">
            {{-- Actor avatar --}}
            <div class="mt-0.5 shrink-0">
                @if ($avatar)
                    <x-filament::avatar
                        src="{{ $avatar }}"
                        alt="{{ $actorName }}"
                        size="sm"
                        :circular="true"
                    />
                @else
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700">
                        <x-filament::icon
                            icon="heroicon-m-user"
                            class="h-4 w-4 text-gray-500 dark:text-gray-400"
                        />
                    </div>
                @endif
            </div>

            {{-- Content --}}
            <div class="min-w-0 flex-1">
                <p class="text-sm text-gray-800 dark:text-gray-200">
                    <span class="font-medium">{{ $actorName }}</span>
                    {{ $eventLabel }}
                    @if ($description)
                        <span class="font-medium">: {{ $description }}</span>
                    @endif
                </p>
                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                    {{ $activity->created_at->diffForHumans() }}
                </p>
            </div>
        </div>

        @if (! $loop->last)
            <div class="ml-4 border-l border-gray-200 dark:border-gray-700 pl-7 -mt-1 -mb-1 h-2"></div>
        @endif
    @empty
        <p class="text-sm text-gray-500 dark:text-gray-400 py-2">
            {{ __('activities.no_activity') }}
        </p>
    @endforelse
</div>
