<!-- About Section -->
<section id="about" class="py-24 md:py-32 bg-white dark:bg-black relative overflow-hidden">
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary/5 dark:bg-primary/10 rounded-full blur-3xl"></div>

    <div class="container max-w-6xl mx-auto px-6 lg:px-8 relative">
        @php $hasContact = __('landing.about.address') || __('landing.about.email') || __('landing.about.phone'); @endphp
        <div class="{{ $hasContact ? 'grid grid-cols-1 lg:grid-cols-2 gap-16 items-center' : 'max-w-2xl mx-auto text-center' }}">
            <!-- Left column: description & mission -->
            <div class="space-y-6">
                <div>
                    <span class="inline-block px-3 py-1 bg-gray-50 dark:bg-gray-900 rounded-full text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-3">
                        {{ __('landing.about.heading') }}
                    </span>
                    <h2 class="font-display mt-4 text-3xl sm:text-4xl font-bold text-black dark:text-white">
                        {{ __('landing.about.subheading') }}
                    </h2>
                </div>

                <p class="text-base md:text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
                    {{ __('landing.about.description') }}
                </p>
            </div>

            <!-- Right column: contact details (only when at least one field is set) -->
            @if($hasContact)
            <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-8 space-y-6">
                @if(__('landing.about.address'))
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 flex h-10 w-10 items-center justify-center rounded-lg bg-white dark:bg-gray-800 text-primary dark:text-primary-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-black dark:text-white mb-1">Address</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('landing.about.address') }}</p>
                        </div>
                    </div>
                @endif

                @if(__('landing.about.email'))
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 flex h-10 w-10 items-center justify-center rounded-lg bg-white dark:bg-gray-800 text-primary dark:text-primary-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-black dark:text-white mb-1">Email</p>
                            <a href="mailto:{{ __('landing.about.email') }}" class="text-sm text-primary dark:text-primary-400 hover:underline">
                                {{ __('landing.about.email') }}
                            </a>
                        </div>
                    </div>
                @endif

                @if(__('landing.about.phone'))
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 flex h-10 w-10 items-center justify-center rounded-lg bg-white dark:bg-gray-800 text-primary dark:text-primary-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-black dark:text-white mb-1">Phone</p>
                            <a href="tel:{{ __('landing.about.phone') }}" class="text-sm text-primary dark:text-primary-400 hover:underline">
                                {{ __('landing.about.phone') }}
                            </a>
                        </div>
                    </div>
                @endif

            </div>
            @endif
        </div>
    </div>
</section>
