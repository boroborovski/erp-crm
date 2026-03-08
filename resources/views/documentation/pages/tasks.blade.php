<h1 id="top">{{ __('docs.pages.tasks.title') }}</h1>

<p>{{ __('docs.pages.tasks.intro') }}</p>

{{-- Creating --}}
<h2 id="creating">{{ __('docs.pages.tasks.creating.heading') }}</h2>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.tasks.creating.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-primary/5 border border-primary/20 p-4">
    <p class="text-sm font-semibold text-primary dark:text-primary-400 mb-1">{{ __('docs.tip') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.tasks.creating.tip') }}</p>
</div>

{{-- Kanban --}}
<h2 id="kanban">{{ __('docs.pages.tasks.kanban.heading') }}</h2>

<p>{{ __('docs.pages.tasks.kanban.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.tasks.kanban.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- Projects --}}
<h2 id="projects">{{ __('docs.pages.tasks.projects.heading') }}</h2>

<p>{{ __('docs.pages.tasks.projects.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.tasks.projects.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>
