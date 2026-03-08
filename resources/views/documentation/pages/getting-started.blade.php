<h1 id="top">{{ __('docs.pages.getting-started.title') }}</h1>

<p>{{ __('docs.pages.getting-started.intro') }}</p>

{{-- Login --}}
<h2 id="login">{{ __('docs.pages.getting-started.login.heading') }}</h2>

<p>{{ __('docs.pages.getting-started.login.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.getting-started.login.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- Workspaces --}}
<h2 id="workspaces">{{ __('docs.pages.getting-started.workspaces.heading') }}</h2>

<p>{{ __('docs.pages.getting-started.workspaces.body') }}</p>

<p class="mt-4 font-medium text-gray-900 dark:text-white">Creating a workspace:</p>
<ol class="mt-2 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.getting-started.workspaces.create_steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<p class="mt-4 font-medium text-gray-900 dark:text-white">Switching workspaces:</p>
<ol class="mt-2 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.getting-started.workspaces.switch_steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-primary/5 border border-primary/20 p-4">
    <p class="text-sm font-semibold text-primary dark:text-primary-400 mb-1">{{ __('docs.tip') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.getting-started.workspaces.invite_tip') }}</p>
</div>

{{-- Profile --}}
<h2 id="profile">{{ __('docs.pages.getting-started.profile.heading') }}</h2>

<p>{{ __('docs.pages.getting-started.profile.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.getting-started.profile.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

{{-- Language --}}
<h2 id="locale">{{ __('docs.pages.getting-started.locale.heading') }}</h2>

<p>{{ __('docs.pages.getting-started.locale.body') }}</p>

<ol class="mt-4 space-y-2 list-decimal list-inside text-gray-600 dark:text-gray-300">
    @foreach(__('docs.pages.getting-started.locale.steps') as $step)
        <li>{{ $step }}</li>
    @endforeach
</ol>

<div class="not-prose mt-4 rounded-lg bg-primary/5 border border-primary/20 p-4">
    <p class="text-sm font-semibold text-primary dark:text-primary-400 mb-1">{{ __('docs.tip') }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('docs.pages.getting-started.locale.tip') }}</p>
</div>
