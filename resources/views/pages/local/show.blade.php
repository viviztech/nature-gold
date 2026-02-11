<x-layouts.app
    :title="__('shop.local_page_title', ['district' => $districtName])"
    :metaDescription="__('shop.local_meta_description', ['district' => $districtName])"
    :jsonLd="$jsonLd"
>
    {{-- Hero --}}
    <section class="bg-gradient-to-br from-nature-700 to-nature-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="text-nature-300 text-sm mb-4">
                <a href="{{ route('home') }}" class="hover:text-white">{{ __('shop.nav_home') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('local.index') }}" class="hover:text-white">{{ __('shop.local_landing_title') }}</a>
                <span class="mx-2">/</span>
                <span class="text-white">{{ $districtName }}</span>
            </nav>
            <h1 class="font-heading text-3xl md:text-4xl font-bold mb-4">
                {{ __('shop.local_district_hero', ['district' => $districtName]) }}
            </h1>
            <p class="text-nature-200 text-lg max-w-2xl">
                {{ __('shop.local_district_subtitle', ['district' => $districtName]) }}
            </p>
        </div>
    </section>

    {{-- Product Types --}}
    <section class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="font-heading text-2xl font-bold text-gray-900 mb-6">
            {{ __('shop.local_products_in', ['district' => $districtName]) }}
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
            @foreach($productTypes as $typeSlug => $type)
                <a href="{{ route('local.product-type', [$typeSlug, $district]) }}"
                   class="block p-6 bg-white rounded-xl border border-gray-200 hover:border-gold-400 hover:shadow-md transition text-center group">
                    <div class="w-12 h-12 mx-auto mb-3 bg-gold-100 text-gold-600 rounded-full flex items-center justify-center group-hover:bg-gold-500 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <span class="font-semibold text-gray-800 group-hover:text-gold-700">
                        {{ app()->getLocale() === 'ta' ? $type['ta'] : $type['en'] }}
                    </span>
                </a>
            @endforeach
        </div>

        {{-- Featured Products --}}
        <h2 class="font-heading text-2xl font-bold text-gray-900 mb-6">{{ __('shop.featured_products') }}</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>

    {{-- Why Nature Gold --}}
    <section class="bg-cream py-12">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="font-heading text-2xl font-bold text-gray-900 mb-8 text-center">
                {{ __('shop.local_why_title', ['district' => $districtName]) }}
            </h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-14 h-14 mx-auto mb-4 bg-nature-100 text-nature-700 rounded-full flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-heading font-semibold text-gray-900 mb-2">{{ __('shop.usp_natural') }}</h3>
                    <p class="text-gray-600 text-sm">{{ __('shop.usp_natural_desc') }}</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 mx-auto mb-4 bg-gold-100 text-gold-700 rounded-full flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="font-heading font-semibold text-gray-900 mb-2">{{ __('shop.usp_cold_pressed') }}</h3>
                    <p class="text-gray-600 text-sm">{{ __('shop.usp_cold_pressed_desc') }}</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 mx-auto mb-4 bg-nature-100 text-nature-700 rounded-full flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    </div>
                    <h3 class="font-heading font-semibold text-gray-900 mb-2">{{ __('shop.local_delivery_title') }}</h3>
                    <p class="text-gray-600 text-sm">{{ __('shop.local_delivery_desc', ['district' => $districtName]) }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Nearby Districts --}}
    @if($nearbyDistricts->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 py-12">
            <h2 class="font-heading text-xl font-bold text-gray-900 mb-6">{{ __('shop.local_nearby') }}</h2>
            <div class="flex flex-wrap gap-3">
                @foreach($nearbyDistricts as $slug => $nearby)
                    <a href="{{ route('local.show', $slug) }}"
                       class="px-4 py-2 bg-white border border-gray-200 rounded-lg hover:border-gold-400 hover:text-gold-700 text-sm font-medium transition">
                        {{ app()->getLocale() === 'ta' ? $nearby['name_ta'] : $nearby['name_en'] }}
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Dealer CTA --}}
    <section class="bg-nature-800 text-white py-12">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h2 class="font-heading text-2xl font-bold mb-4">{{ __('shop.local_dealer_cta', ['district' => $districtName]) }}</h2>
            <p class="text-nature-200 mb-6">{{ __('shop.local_dealer_cta_desc') }}</p>
            <a href="{{ route('dealer.register') }}" class="inline-block px-8 py-3 bg-gold-500 text-white font-semibold rounded-xl hover:bg-gold-600 transition">
                {{ __('shop.become_dealer') }}
            </a>
        </div>
    </section>

</x-layouts.app>
