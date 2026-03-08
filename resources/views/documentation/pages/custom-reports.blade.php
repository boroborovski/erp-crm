<h1 id="top">{{ __('docs.pages.custom-reports.title') }}</h1>

<p>{{ __('docs.pages.custom-reports.intro') }}</p>

{{-- Building --}}
<h2 id="building">{{ __('docs.pages.custom-reports.building.heading') }}</h2>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.custom-reports.building.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- Filters --}}
<h2 id="filters">{{ __('docs.pages.custom-reports.filters.heading') }}</h2>

<p>{{ __('docs.pages.custom-reports.filters.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.custom-reports.filters.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-primary/5 border border-primary/20 p-4">
    <p class="text-sm font-semibold text-primary dark:text-primary-400 mb-1">{{ __('docs.tip') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.custom-reports.filters.tip') }}</p>
</div>

{{-- Running --}}
<h2 id="running">{{ __('docs.pages.custom-reports.running.heading') }}</h2>

<p>{{ __('docs.pages.custom-reports.running.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.custom-reports.running.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-4">
    <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">{{ __('docs.note') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.custom-reports.running.note') }}</p>
</div>
