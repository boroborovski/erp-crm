<h1 id="top">{{ __('docs.pages.people.title') }}</h1>

<p>{{ __('docs.pages.people.intro') }}</p>

{{-- Adding --}}
<h2 id="adding">{{ __('docs.pages.people.adding.heading') }}</h2>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.people.adding.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- Linking --}}
<h2 id="linking">{{ __('docs.pages.people.linking.heading') }}</h2>

<p>{{ __('docs.pages.people.linking.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.people.linking.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-primary/5 border border-primary/20 p-4">
    <p class="text-sm font-semibold text-primary dark:text-primary-400 mb-1">{{ __('docs.tip') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.people.linking.tip') }}</p>
</div>

{{-- Email thread --}}
<h2 id="email-thread">{{ __('docs.pages.people.email_thread.heading') }}</h2>

<p>{{ __('docs.pages.people.email_thread.body') }}</p>

{{-- Activity --}}
<h2 id="activity">{{ __('docs.pages.people.activity.heading') }}</h2>

<p>{{ __('docs.pages.people.activity.body') }}</p>
