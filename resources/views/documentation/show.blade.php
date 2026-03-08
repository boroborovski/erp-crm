<x-guest-layout
    :title="__('docs.pages.' . $page . '.title') . ' — ' . __('docs.nav_title') . ' — ' . config('app.name')"
    :description="__('docs.pages.' . $page . '.intro')">

{{-- Group pages by section for the sidebar --}}
@php
    $sectionOrder = ['getting_started', 'crm', 'erp', 'configuration'];
    $grouped = [];
    foreach ($sections as $entry) {
        $grouped[$entry['section']][] = $entry['slug'];
    }
@endphp

<div class="min-h-screen bg-white dark:bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-16">
        <div class="lg:grid lg:grid-cols-[260px_1fr] lg:gap-12 xl:gap-16">

            {{-- ── Sidebar ────────────────────────────────────────────────── --}}
            <aside class="lg:block">

                {{-- Mobile: collapsible dropdown --}}
                <div class="lg:hidden mb-6">
                    <button
                        id="docs-mobile-toggle"
                        type="button"
                        class="flex w-full items-center justify-between rounded-md border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm font-medium text-gray-900 dark:text-white shadow-sm"
                        aria-expanded="false">
                        <span>{{ __('docs.nav_title') }}</span>
                        <svg class="h-4 w-4 text-gray-500 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="docs-mobile-nav" class="hidden mt-2 rounded-md border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-4 shadow-lg">
                        @foreach($sectionOrder as $sectionKey)
                            @if(!empty($grouped[$sectionKey]))
                                <p class="mb-2 mt-4 first:mt-0 text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                                    {{ __('docs.sections.' . $sectionKey) }}
                                </p>
                                <ul class="space-y-1">
                                    @foreach($grouped[$sectionKey] as $slug)
                                        <li>
                                            <a href="{{ route('documentation.show', $slug) }}"
                                               class="block rounded px-3 py-1.5 text-sm transition-colors
                                                {{ $slug === $page
                                                    ? 'bg-primary/10 text-primary dark:text-primary-400 font-medium'
                                                    : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                                {{ __('docs.pages.' . $slug . '.nav_label') }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Desktop: sticky sidebar --}}
                <nav class="hidden lg:block sticky top-24 space-y-6 max-h-[calc(100vh-8rem)] overflow-y-auto pr-2">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-4">
                        {{ __('docs.nav_title') }}
                    </p>

                    {{-- Language switcher --}}
                    <div class="flex items-center space-x-1 text-xs font-medium mb-6">
                        <a href="{{ route('locale.switch', 'en') }}"
                           class="px-2 py-1 rounded transition-colors {{ app()->getLocale() === 'en' ? 'text-primary dark:text-primary-400 font-semibold' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">EN</a>
                        <span class="text-gray-300 dark:text-gray-700">|</span>
                        <a href="{{ route('locale.switch', 'bg') }}"
                           class="px-2 py-1 rounded transition-colors {{ app()->getLocale() === 'bg' ? 'text-primary dark:text-primary-400 font-semibold' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">BG</a>
                    </div>

                    @foreach($sectionOrder as $sectionKey)
                        @if(!empty($grouped[$sectionKey]))
                            <div>
                                <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                                    {{ __('docs.sections.' . $sectionKey) }}
                                </p>
                                <ul class="space-y-0.5">
                                    @foreach($grouped[$sectionKey] as $slug)
                                        <li>
                                            <a href="{{ route('documentation.show', $slug) }}"
                                               class="block rounded px-3 py-1.5 text-sm transition-colors
                                                {{ $slug === $page
                                                    ? 'bg-primary/10 text-primary dark:text-primary-400 font-medium'
                                                    : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                                {{ __('docs.pages.' . $slug . '.nav_label') }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </nav>
            </aside>

            {{-- ── Main content ───────────────────────────────────────────── --}}
            <main class="min-w-0">
                <div class="prose prose-gray dark:prose-invert max-w-none
                    prose-headings:scroll-mt-24
                    prose-h1:text-3xl prose-h1:font-bold prose-h1:text-black dark:prose-h1:text-white prose-h1:mb-4
                    prose-h2:text-xl prose-h2:font-semibold prose-h2:text-black dark:prose-h2:text-white prose-h2:mt-10 prose-h2:mb-4
                    prose-p:text-gray-600 dark:prose-p:text-gray-300 prose-p:leading-relaxed
                    prose-li:text-gray-600 dark:prose-li:text-gray-300
                    prose-a:text-primary dark:prose-a:text-primary-400 prose-a:no-underline hover:prose-a:underline
                    prose-code:before:content-none prose-code:after:content-none">

                    @include('documentation.pages.' . $page)

                </div>

                {{-- Prev / Next navigation --}}
                @php
                    $allSlugs = array_column($sections, 'slug');
                    $currentIndex = array_search($page, $allSlugs, true);
                    $prevSlug = $currentIndex > 0 ? $allSlugs[$currentIndex - 1] : null;
                    $nextSlug = $currentIndex < count($allSlugs) - 1 ? $allSlugs[$currentIndex + 1] : null;
                @endphp

                @if($prevSlug || $nextSlug)
                    <div class="mt-12 pt-8 border-t border-gray-100 dark:border-gray-800 flex justify-between items-center gap-4">
                        @if($prevSlug)
                            <a href="{{ route('documentation.show', $prevSlug) }}"
                               class="group flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary-400 transition-colors">
                                <svg class="h-4 w-4 transition-transform group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span>
                                    <span class="block text-xs text-gray-400 dark:text-gray-500">{{ __('docs.prev_page') }}</span>
                                    <span class="font-medium">{{ __('docs.pages.' . $prevSlug . '.nav_label') }}</span>
                                </span>
                            </a>
                        @else
                            <div></div>
                        @endif

                        @if($nextSlug)
                            <a href="{{ route('documentation.show', $nextSlug) }}"
                               class="group flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary-400 transition-colors text-right">
                                <span>
                                    <span class="block text-xs text-gray-400 dark:text-gray-500">{{ __('docs.next_page') }}</span>
                                    <span class="font-medium">{{ __('docs.pages.' . $nextSlug . '.nav_label') }}</span>
                                </span>
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                @endif
            </main>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('docs-mobile-toggle');
        const nav    = document.getElementById('docs-mobile-nav');
        if (!toggle || !nav) return;

        toggle.addEventListener('click', function () {
            const isOpen = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', String(!isOpen));
            nav.classList.toggle('hidden', isOpen);
            toggle.querySelector('svg').classList.toggle('rotate-180', !isOpen);
        });
    });
</script>

</x-guest-layout>
