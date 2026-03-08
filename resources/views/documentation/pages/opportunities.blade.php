<h1 id="top">{{ __('docs.pages.opportunities.title') }}</h1>

<p>{{ __('docs.pages.opportunities.intro') }}</p>

{{-- Creating --}}
<h2 id="creating">{{ __('docs.pages.opportunities.creating.heading') }}</h2>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.opportunities.creating.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- Pipeline stages --}}
<h2 id="pipeline">{{ __('docs.pages.opportunities.pipeline.heading') }}</h2>

<p>{{ __('docs.pages.opportunities.pipeline.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.opportunities.pipeline.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- Kanban --}}
<h2 id="kanban">{{ __('docs.pages.opportunities.kanban.heading') }}</h2>

<p>{{ __('docs.pages.opportunities.kanban.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.opportunities.kanban.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-primary/5 border border-primary/20 p-4">
    <p class="text-sm font-semibold text-primary dark:text-primary-400 mb-1">{{ __('docs.tip') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.opportunities.kanban.tip') }}</p>
</div>

{{-- Quotes --}}
<h2 id="quotes">{{ __('docs.pages.opportunities.quotes.heading') }}</h2>

<p>{{ __('docs.pages.opportunities.quotes.body') }}</p>
