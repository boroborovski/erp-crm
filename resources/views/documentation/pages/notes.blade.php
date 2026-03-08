<h1 id="top">{{ __('docs.pages.notes.title') }}</h1>

<p>{{ __('docs.pages.notes.intro') }}</p>

{{-- Adding --}}
<h2 id="adding">{{ __('docs.pages.notes.adding.heading') }}</h2>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.notes.adding.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-primary/5 border border-primary/20 p-4">
    <p class="text-sm font-semibold text-primary dark:text-primary-400 mb-1">{{ __('docs.tip') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.notes.adding.tip') }}</p>
</div>

{{-- Managing --}}
<h2 id="managing">{{ __('docs.pages.notes.managing.heading') }}</h2>

<p>{{ __('docs.pages.notes.managing.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.notes.managing.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- Multiple records --}}
<h2 id="linked">{{ __('docs.pages.notes.linked.heading') }}</h2>

<p>{{ __('docs.pages.notes.linked.body') }}</p>
