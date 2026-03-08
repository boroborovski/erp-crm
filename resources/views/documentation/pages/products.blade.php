<h1 id="top">{{ __('docs.pages.products.title') }}</h1>

<p>{{ __('docs.pages.products.intro') }}</p>

{{-- Creating --}}
<h2 id="creating">{{ __('docs.pages.products.creating.heading') }}</h2>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.products.creating.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-primary/5 border border-primary/20 p-4">
    <p class="text-sm font-semibold text-primary dark:text-primary-400 mb-1">{{ __('docs.tip') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.products.creating.tip') }}</p>
</div>

{{-- Categories --}}
<h2 id="categories">{{ __('docs.pages.products.categories.heading') }}</h2>

<p>{{ __('docs.pages.products.categories.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.products.categories.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- Units --}}
<h2 id="units">{{ __('docs.pages.products.units.heading') }}</h2>

<p>{{ __('docs.pages.products.units.body') }}</p>

<ul class="mt-4 space-y-2 list-disc list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.products.units.items') as $item)
        <li>
            @php $parts = explode(' — ', $item, 2); @endphp
            <code class="bg-gray-100 dark:bg-gray-900 px-1.5 py-0.5 rounded text-sm font-mono text-gray-800 dark:text-gray-200">{{ $parts[0] }}</code>
            @if(isset($parts[1])) — {{ $parts[1] }} @endif
        </li>
    @endforeach
</ul>

{{-- Active / Inactive --}}
<h2 id="active">{{ __('docs.pages.products.active.heading') }}</h2>

<p>{{ __('docs.pages.products.active.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.products.active.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>
