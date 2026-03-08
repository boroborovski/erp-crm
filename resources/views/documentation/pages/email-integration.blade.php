<h1 id="top">{{ __('docs.pages.email-integration.title') }}</h1>

<p>{{ __('docs.pages.email-integration.intro') }}</p>

{{-- IMAP Setup --}}
<h2 id="imap-setup">{{ __('docs.pages.email-integration.imap_setup.heading') }}</h2>

<p>{{ __('docs.pages.email-integration.imap_setup.body') }}</p>

<ul class="mt-4 space-y-2 list-disc list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.email-integration.imap_setup.vars') as $var)
        <li>
            @php $parts = explode(' — ', $var, 2); @endphp
            <code class="bg-gray-100 dark:bg-gray-900 px-1.5 py-0.5 rounded text-sm font-mono text-gray-800 dark:text-gray-200">{{ $parts[0] }}</code>
            @if(isset($parts[1])) — {{ $parts[1] }} @endif
        </li>
    @endforeach
</ul>

<div class="not-prose mt-4 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-4">
    <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">{{ __('docs.note') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.email-integration.imap_setup.note') }}</p>
</div>

<p class="mt-4 text-gray-600 dark:text-gray-300">{{ __('docs.pages.email-integration.imap_setup.after') }}</p>

{{-- Composing --}}
<h2 id="composing">{{ __('docs.pages.email-integration.composing.heading') }}</h2>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.email-integration.composing.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-primary/5 border border-primary/20 p-4">
    <p class="text-sm font-semibold text-primary dark:text-primary-400 mb-1">{{ __('docs.tip') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.email-integration.composing.tip') }}</p>
</div>

{{-- Inbound --}}
<h2 id="inbound">{{ __('docs.pages.email-integration.inbound.heading') }}</h2>

<p>{{ __('docs.pages.email-integration.inbound.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.email-integration.inbound.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-4">
    <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">{{ __('docs.note') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.email-integration.inbound.note') }}</p>
</div>
