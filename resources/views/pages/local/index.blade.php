<x-layouts.app :title="__('shop.local_landing_title')" :metaDescription="__('shop.seo_local_description')" :jsonLd="$jsonLd">

    {{-- Hero --}}
    <section class="bg-gradient-to-br from-nature-700 to-nature-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="font-heading text-3xl md:text-4xl font-bold mb-4">{{ __('shop.local_hero_title') }}</h1>
            <p class="text-nature-200 text-lg max-w-2xl mx-auto">{{ __('shop.local_hero_subtitle') }}</p>
        </div>
    </section>

    {{-- District Grid --}}
    <section class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="font-heading text-2xl font-bold text-gray-900 mb-8 text-center">{{ __('shop.local_districts_heading') }}</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($districts as $slug => $district)
                <a href="{{ route('local.show', $slug) }}"
                   class="block p-4 bg-white rounded-xl border border-gray-200 hover:border-gold-400 hover:shadow-md transition text-center group">
                    <div class="w-10 h-10 mx-auto mb-2 bg-gold-100 text-gold-600 rounded-full flex items-center justify-center group-hover:bg-gold-500 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="font-medium text-gray-800 group-hover:text-gold-700 text-sm">
                        {{ app()->getLocale() === 'ta' ? $district['name_ta'] : $district['name_en'] }}
                    </span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-cream py-12">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h2 class="font-heading text-2xl font-bold text-gray-900 mb-4">{{ __('shop.local_cta_title') }}</h2>
            <p class="text-gray-600 mb-6">{{ __('shop.local_cta_subtitle') }}</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('shop') }}" class="px-8 py-3 bg-gold-500 text-white font-semibold rounded-xl hover:bg-gold-600 transition">{{ __('shop.shop_now') }}</a>
                <a href="{{ route('dealer.register') }}" class="px-8 py-3 border-2 border-nature-600 text-nature-700 font-semibold rounded-xl hover:bg-nature-50 transition">{{ __('shop.become_dealer') }}</a>
            </div>
        </div>
    </section>

</x-layouts.app>
