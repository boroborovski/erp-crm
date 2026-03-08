<!-- Modern Minimalist Features Section -->
<section id="features" class="py-24 md:py-32 bg-gray-50 dark:bg-gray-950 relative overflow-hidden">
    <!-- Subtle gradient background element -->
    <div class="absolute -bottom-64 left-0 w-96 h-96 bg-primary/5 dark:bg-primary/10 rounded-full blur-3xl"></div>

    <div class="container max-w-6xl mx-auto px-6 lg:px-8 relative">
        <!-- Section Header -->
        <div class="max-w-3xl mx-auto text-center mb-16 md:mb-20">
            <span class="inline-block px-3 py-1 bg-white dark:bg-gray-900 rounded-full text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-3">
                {{ __('landing.features.badge') }}
            </span>
            <h2 class="font-display mt-4 text-3xl sm:text-4xl font-bold text-black dark:text-white">
                {{ __('landing.features.heading') }}
            </h2>
            <p class="mt-5 text-base md:text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed">
                {{ __('landing.features.subheading') }}
            </p>
        </div>

        <!-- Features Grid - Cleaner & More Minimal -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php $features = __('landing.features.items'); @endphp

            @foreach ($features as $feature)
                <div class="group relative bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-6 transition-all duration-300 hover:border-gray-200 dark:hover:border-gray-700 hover:shadow-sm">
                    <div class="mb-5">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50 dark:bg-gray-800 text-primary dark:text-primary-400 group-hover:bg-primary/10 dark:group-hover:bg-primary/20 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                {!! $feature['icon'] !!}
                            </svg>
                        </div>
                    </div>
                    <h3 class="font-display text-lg font-medium text-black dark:text-white mb-2 group-hover:text-primary dark:group-hover:text-primary-400 transition-colors duration-300">
                        {{ $feature['title'] }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                        {{ $feature['description'] }}
                    </p>
                </div>
            @endforeach
        </div>

        <!-- Call-to-action - Simplified -->
        <div class="mt-20 text-center">
            <div class="inline-block pt-10 px-4 md:px-8 border-t border-gray-200 dark:border-gray-800 max-w-2xl mx-auto">
                <h3 class="font-display text-xl font-semibold text-black dark:text-white mb-4">{{ __('landing.features.cta_heading') }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-6 text-base">{{ __('landing.features.cta_subheading') }}</p>
                <a href="{{ route('login') }}" class="group inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary-600 text-white px-8 py-3.5 rounded-md font-medium text-base transition-all duration-300">
                    <span>{{ __('landing.features.cta_button') }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
