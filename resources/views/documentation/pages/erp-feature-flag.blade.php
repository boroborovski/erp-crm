<h1 id="top">{{ __('docs.pages.erp-feature-flag.title') }}</h1>

<p>{{ __('docs.pages.erp-feature-flag.intro') }}</p>

{{-- Enabling --}}
<h2 id="enabling">{{ __('docs.pages.erp-feature-flag.enabling.heading') }}</h2>

<p>{{ __('docs.pages.erp-feature-flag.enabling.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.erp-feature-flag.enabling.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-4">
    <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">{{ __('docs.note') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.erp-feature-flag.enabling.note') }}</p>
</div>

{{-- Visibility --}}
<h2 id="visibility">{{ __('docs.pages.erp-feature-flag.visibility.heading') }}</h2>

<p>{{ __('docs.pages.erp-feature-flag.visibility.body') }}</p>

<ul class="mt-4 space-y-2 list-disc list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.erp-feature-flag.visibility.items') as $item)
        <li>{{ $item }}</li>
    @endforeach
</ul>
