<h1 id="top">{{ __('docs.pages.quotes.title') }}</h1>

<p>{{ __('docs.pages.quotes.intro') }}</p>

{{-- Creating --}}
<h2 id="creating">{{ __('docs.pages.quotes.creating.heading') }}</h2>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.quotes.creating.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-primary/5 border border-primary/20 p-4">
    <p class="text-sm font-semibold text-primary dark:text-primary-400 mb-1">{{ __('docs.tip') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.quotes.creating.tip') }}</p>
</div>

{{-- Status --}}
<h2 id="status">{{ __('docs.pages.quotes.status.heading') }}</h2>

<p>{{ __('docs.pages.quotes.status.body') }}</p>

<ul class="mt-4 space-y-2 list-disc list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.quotes.status.items') as $item)
        <li>{{ $item }}</li>
    @endforeach
</ul>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.quotes.status.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- PDF --}}
<h2 id="pdf">{{ __('docs.pages.quotes.pdf.heading') }}</h2>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.quotes.pdf.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- Convert --}}
<h2 id="convert">{{ __('docs.pages.quotes.convert.heading') }}</h2>

<p>{{ __('docs.pages.quotes.convert.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.quotes.convert.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-4">
    <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">{{ __('docs.note') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.quotes.convert.note') }}</p>
</div>
