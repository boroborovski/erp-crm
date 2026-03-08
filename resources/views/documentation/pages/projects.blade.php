<h1 id="top">{{ __('docs.pages.projects.title') }}</h1>

<p>{{ __('docs.pages.projects.intro') }}</p>

{{-- Creating --}}
<h2 id="creating">{{ __('docs.pages.projects.creating.heading') }}</h2>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.projects.creating.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- Milestones --}}
<h2 id="milestones">{{ __('docs.pages.projects.milestones.heading') }}</h2>

<p>{{ __('docs.pages.projects.milestones.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.projects.milestones.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- Tasks --}}
<h2 id="tasks">{{ __('docs.pages.projects.tasks.heading') }}</h2>

<p>{{ __('docs.pages.projects.tasks.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.projects.tasks.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- Kanban --}}
<h2 id="kanban">{{ __('docs.pages.projects.kanban.heading') }}</h2>

<p>{{ __('docs.pages.projects.kanban.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.projects.kanban.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>
