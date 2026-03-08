<x-guest-layout
    :title="config('app.name') . ' - ' . __('landing.meta.title')"
    :description="__('landing.meta.description')"
    :ogTitle="config('app.name') . ' - ' . __('landing.meta.og_title')"
    :ogDescription="__('landing.meta.og_description')"
    :ogImage="url('/images/og-image.jpg')">
    @include('home.partials.hero')
    @include('home.partials.features')
    @include('home.partials.about')
</x-guest-layout>
