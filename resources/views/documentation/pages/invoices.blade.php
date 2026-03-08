<h1 id="top">{{ __('docs.pages.invoices.title') }}</h1>

<p>{{ __('docs.pages.invoices.intro') }}</p>

{{-- Issuing --}}
<h2 id="issuing">{{ __('docs.pages.invoices.issuing.heading') }}</h2>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.invoices.issuing.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-primary/5 border border-primary/20 p-4">
    <p class="text-sm font-semibold text-primary dark:text-primary-400 mb-1">{{ __('docs.tip') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.invoices.issuing.tip') }}</p>
</div>

{{-- Payments --}}
<h2 id="payments">{{ __('docs.pages.invoices.payments.heading') }}</h2>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.invoices.payments.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- Status --}}
<h2 id="status">{{ __('docs.pages.invoices.status.heading') }}</h2>

<p>{{ __('docs.pages.invoices.status.body') }}</p>

<ul class="mt-4 space-y-2 list-disc list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.invoices.status.items') as $item)
        <li>{{ $item }}</li>
    @endforeach
</ul>

{{-- Overdue --}}
<h2 id="overdue">{{ __('docs.pages.invoices.overdue.heading') }}</h2>

<p>{{ __('docs.pages.invoices.overdue.body') }}</p>

{{-- PDF --}}
<h2 id="pdf">{{ __('docs.pages.invoices.pdf.heading') }}</h2>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.invoices.pdf.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>
