<h1 id="top">{{ __('docs.pages.companies.title') }}</h1>

<p>{{ __('docs.pages.companies.intro') }}</p>

{{-- Creating --}}
<h2 id="creating">{{ __('docs.pages.companies.creating.heading') }}</h2>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.companies.creating.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-primary/5 border border-primary/20 p-4">
    <p class="text-sm font-semibold text-primary dark:text-primary-400 mb-1">{{ __('docs.tip') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.companies.creating.tip') }}</p>
</div>

{{-- Editing --}}
<h2 id="editing">{{ __('docs.pages.companies.editing.heading') }}</h2>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.companies.editing.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- Custom fields --}}
<h2 id="custom-fields">{{ __('docs.pages.companies.custom_fields.heading') }}</h2>

<p>{{ __('docs.pages.companies.custom_fields.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.companies.custom_fields.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-4">
    <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">{{ __('docs.note') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.companies.custom_fields.note') }}</p>
</div>

{{-- Activity --}}
<h2 id="activity">{{ __('docs.pages.companies.activity.heading') }}</h2>

<p>{{ __('docs.pages.companies.activity.body') }}</p>

{{-- Emails --}}
<h2 id="emails">{{ __('docs.pages.companies.emails.heading') }}</h2>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.companies.emails.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- Quotes & Invoices --}}
<h2 id="quotes-invoices">{{ __('docs.pages.companies.quotes_invoices.heading') }}</h2>

<p>{{ __('docs.pages.companies.quotes_invoices.body') }}</p>
