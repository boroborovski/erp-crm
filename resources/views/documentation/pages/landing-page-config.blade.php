<h1 id="top">{{ __('docs.pages.landing-page-config.title') }}</h1>

<p>{{ __('docs.pages.landing-page-config.intro') }}</p>

{{-- Environment variables --}}
<h2 id="env-vars">{{ __('docs.pages.landing-page-config.env_vars.heading') }}</h2>

<p>{{ __('docs.pages.landing-page-config.env_vars.body') }}</p>

<ul class="mt-4 space-y-3 list-disc list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.landing-page-config.env_vars.items') as $item)
        <li>
            @php $parts = explode(' — ', $item, 2); @endphp
            <code class="bg-gray-100 dark:bg-gray-900 px-1.5 py-0.5 rounded text-sm font-mono text-gray-800 dark:text-gray-200">{{ $parts[0] }}</code>
            @if(isset($parts[1])) — {{ $parts[1] }} @endif
        </li>
    @endforeach
</ul>

<ol class="mt-6 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.landing-page-config.env_vars.steps') as $step)
        <li>
            @php $codeParts = preg_split('/(`[^`]+`)/', $step, -1, PREG_SPLIT_DELIM_CAPTURE); @endphp
            @foreach($codeParts as $part)
                @if(str_starts_with($part, '`') && str_ends_with($part, '`'))
                    <code class="bg-gray-100 dark:bg-gray-900 px-1.5 py-0.5 rounded text-sm font-mono text-gray-800 dark:text-gray-200">{{ trim($part, '`') }}</code>
                @else
                    {{ $part }}
                @endif
            @endforeach
        </li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-primary/5 border border-primary/20 p-4">
    <p class="text-sm font-semibold text-primary dark:text-primary-400 mb-1">{{ __('docs.tip') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.landing-page-config.env_vars.tip') }}</p>
</div>

{{-- Copy --}}
<h2 id="copy">{{ __('docs.pages.landing-page-config.copy.heading') }}</h2>

<p>{{ __('docs.pages.landing-page-config.copy.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.landing-page-config.copy.steps') as $step)
        <li>
            @php $codeParts = preg_split('/(`[^`]+`)/', $step, -1, PREG_SPLIT_DELIM_CAPTURE); @endphp
            @foreach($codeParts as $part)
                @if(str_starts_with($part, '`') && str_ends_with($part, '`'))
                    <code class="bg-gray-100 dark:bg-gray-900 px-1.5 py-0.5 rounded text-sm font-mono text-gray-800 dark:text-gray-200">{{ trim($part, '`') }}</code>
                @else
                    {{ $part }}
                @endif
            @endforeach
        </li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-4">
    <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">{{ __('docs.note') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.landing-page-config.copy.note') }}</p>
</div>

{{-- Features --}}
<h2 id="features">{{ __('docs.pages.landing-page-config.features.heading') }}</h2>

<p>{{ __('docs.pages.landing-page-config.features.body') }}</p>

<div class="not-prose mt-4 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-4">
    <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">{{ __('docs.note') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.landing-page-config.features.note') }}</p>
</div>
