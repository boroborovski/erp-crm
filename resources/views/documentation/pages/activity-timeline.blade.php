<h1 id="top">{{ __('docs.pages.activity-timeline.title') }}</h1>

<p>{{ __('docs.pages.activity-timeline.intro') }}</p>

{{-- Events --}}
<h2 id="events">{{ __('docs.pages.activity-timeline.events.heading') }}</h2>

<p>{{ __('docs.pages.activity-timeline.events.body') }}</p>

<ul class="mt-4 space-y-2 list-disc list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.activity-timeline.events.items') as $item)
        <li>{{ $item }}</li>
    @endforeach
</ul>

<div class="not-prose mt-4 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-4">
    <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">{{ __('docs.note') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.activity-timeline.events.note') }}</p>
</div>

{{-- Reading --}}
<h2 id="reading">{{ __('docs.pages.activity-timeline.reading.heading') }}</h2>

<p>{{ __('docs.pages.activity-timeline.reading.body') }}</p>

<ul class="mt-4 space-y-2 list-disc list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.activity-timeline.reading.items') as $item)
        <li>{{ $item }}</li>
    @endforeach
</ul>

{{-- Filtering --}}
<h2 id="filtering">{{ __('docs.pages.activity-timeline.filtering.heading') }}</h2>

<p>{{ __('docs.pages.activity-timeline.filtering.body') }}</p>
