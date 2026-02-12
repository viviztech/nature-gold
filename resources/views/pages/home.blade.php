<x-layouts.app :title="__('shop.deepam_hero_title')">

    {{-- Hero Section --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-40 h-40 bg-gold-400 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-60 h-60 bg-amber-300 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-orange-200 rounded-full blur-3xl"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 py-16 md:py-24 lg:py-32 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                {{-- Diya Icon --}}
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gold-100 rounded-full mb-6">
                    <svg class="w-10 h-10 text-gold-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C12 2 10 6 10 8C10 9.1 10.9 10 12 10C13.1 10 14 9.1 14 8C14 6 12 2 12 2Z"/>
                        <path d="M8 12C6 12 4 14 4 16C4 18.2 5.8 20 8 20H16C18.2 20 20 18.2 20 16C20 14 18 12 16 12H8Z" opacity="0.6"/>
                        <path d="M6 20H18V22H6V20Z" opacity="0.4"/>
                    </svg>
                </div>

                <p class="text-gold-600 font-medium uppercase tracking-widest text-sm mb-3">{{ __('shop.deepam_hero_subtitle') }}</p>
                <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                    {{ __('shop.deepam_hero_title') }}
                </h1>
                <p class="mt-4 text-xl md:text-2xl font-heading text-gold-700 font-semibold">
                    {{ __('shop.deepam_hero_tagline') }}
                </p>
                <p class="mt-4 text-gray-600 text-lg max-w-xl mx-auto">
                    {{ __('shop.deepam_hero_desc') }}
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#products" class="inline-block px-8 py-3 bg-gold-500 text-white font-semibold rounded-lg hover:bg-gold-600 transition shadow-lg">
                        {{ __('shop.deepam_view_products') }}
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('store_whatsapp', '+919876543210')) }}?text={{ urlencode(__('shop.deepam_whatsapp_msg')) }}"
                       target="_blank"
                       class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition shadow-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        {{ __('shop.deepam_enquire_now') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Product Showcase --}}
    <section id="products" class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-gray-900">{{ __('shop.deepam_products_title') }}</h2>
                <div class="mt-3 w-20 h-1 bg-gold-500 mx-auto rounded"></div>
                <p class="mt-4 text-gray-600 max-w-lg mx-auto">{{ __('shop.deepam_products_subtitle') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                @foreach($products as $product)
                    <div class="group relative bg-gradient-to-b from-amber-50 to-white rounded-2xl border border-gold-100 p-6 md:p-8 text-center hover:shadow-xl hover:border-gold-300 transition-all duration-300">
                        {{-- Coming Soon Badge --}}
                        <div class="absolute top-4 right-4 bg-gold-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                            {{ __('shop.deepam_coming_soon') }}
                        </div>

                        {{-- Product Image --}}
                        <div class="relative mx-auto w-48 h-64 md:w-56 md:h-72 mb-6 group-hover:scale-105 transition-transform duration-300">
                            <img src="{{ $product['image'] }}"
                                 alt="Nature Gold Deepam Lamp Oil {{ $product['size'] }}"
                                 class="w-full h-full object-contain drop-shadow-lg"
                                 loading="lazy">
                        </div>

                        {{-- Product Info --}}
                        <h3 class="font-heading text-xl font-bold text-gray-900">{{ __('shop.deepam_product_name') }}</h3>
                        <p class="text-2xl font-bold text-gold-600 mt-2">{{ $product['size'] }}</p>
                        <p class="text-gray-500 text-sm mt-2">{{ __('shop.deepam_product_short_desc') }}</p>

                        {{-- Enquire Button --}}
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('store_whatsapp', '+919876543210')) }}?text={{ urlencode(__('shop.deepam_whatsapp_product_msg', ['size' => $product['size']])) }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 mt-6 px-6 py-2.5 bg-green-500 text-white font-medium rounded-lg hover:bg-green-600 transition text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            {{ __('shop.deepam_enquire_now') }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Benefits Section --}}
    <section class="py-16 md:py-20 bg-gradient-to-b from-white to-amber-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-gray-900">{{ __('shop.deepam_benefits_title') }}</h2>
                <div class="mt-3 w-20 h-1 bg-gold-500 mx-auto rounded"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                {{-- Benefit 1: 5 Pure Oils --}}
                <div class="text-center p-6 bg-white rounded-xl shadow-sm border border-gold-100 hover:shadow-md transition">
                    <div class="w-14 h-14 mx-auto bg-gold-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <h3 class="font-heading font-bold text-gray-900 text-sm">{{ __('shop.deepam_benefit_1') }}</h3>
                </div>

                {{-- Benefit 2: Pure & Smokeless --}}
                <div class="text-center p-6 bg-white rounded-xl shadow-sm border border-gold-100 hover:shadow-md transition">
                    <div class="w-14 h-14 mx-auto bg-nature-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-nature-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-heading font-bold text-gray-900 text-sm">{{ __('shop.deepam_benefit_2') }}</h3>
                </div>

                {{-- Benefit 3: Long Lasting Flame --}}
                <div class="text-center p-6 bg-white rounded-xl shadow-sm border border-gold-100 hover:shadow-md transition">
                    <div class="w-14 h-14 mx-auto bg-amber-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/></svg>
                    </div>
                    <h3 class="font-heading font-bold text-gray-900 text-sm">{{ __('shop.deepam_benefit_3') }}</h3>
                </div>

                {{-- Benefit 4: Pleasant Aroma --}}
                <div class="text-center p-6 bg-white rounded-xl shadow-sm border border-gold-100 hover:shadow-md transition">
                    <div class="w-14 h-14 mx-auto bg-gold-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <h3 class="font-heading font-bold text-gray-900 text-sm">{{ __('shop.deepam_benefit_4') }}</h3>
                </div>

                {{-- Benefit 5: Daily & Festival --}}
                <div class="text-center p-6 bg-white rounded-xl shadow-sm border border-gold-100 hover:shadow-md transition col-span-2 md:col-span-1">
                    <div class="w-14 h-14 mx-auto bg-nature-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-nature-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="font-heading font-bold text-gray-900 text-sm">{{ __('shop.deepam_benefit_5') }}</h3>
                </div>
            </div>
        </div>
    </section>

    {{-- About the Product --}}
    <section class="py-16 md:py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-gray-900">{{ __('shop.deepam_about_title') }}</h2>
                <div class="mt-3 w-20 h-1 bg-gold-500 mx-auto rounded"></div>
            </div>

            <div class="prose prose-lg mx-auto text-center text-gray-600">
                <p>{{ __('shop.deepam_about_desc') }}</p>
            </div>

            <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-amber-50 rounded-xl p-6 border border-amber-100">
                    <h4 class="font-heading font-bold text-gray-900 mb-2">{{ __('shop.deepam_marketed_by') }}</h4>
                    <p class="text-gray-600 text-sm">Nature Care FMCG Products</p>
                    <p class="text-gray-500 text-sm">Puducherry - 605008</p>
                </div>
                <div class="bg-nature-50 rounded-xl p-6 border border-nature-100">
                    <h4 class="font-heading font-bold text-gray-900 mb-2">{{ __('shop.deepam_manufactured_by') }}</h4>
                    <p class="text-gray-600 text-sm">JE HERBAL</p>
                    <p class="text-gray-500 text-sm">Villupuram, Tamil Nadu</p>
                </div>
            </div>

            <div class="mt-8 bg-red-50 border border-red-200 rounded-xl p-4 text-center">
                <p class="text-red-700 font-semibold text-sm">{{ __('shop.deepam_caution') }}</p>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-16 md:py-20 bg-gradient-to-br from-nature-900 to-nature-800">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="font-heading text-3xl md:text-4xl font-bold text-white">{{ __('shop.deepam_cta_title') }}</h2>
            <p class="mt-4 text-nature-200 text-lg">{{ __('shop.deepam_cta_desc') }}</p>

            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('store_whatsapp', '+919876543210')) }}?text={{ urlencode(__('shop.deepam_whatsapp_msg')) }}"
                   target="_blank"
                   class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition shadow-lg text-lg">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    {{ __('shop.deepam_cta_whatsapp') }}
                </a>
                <a href="tel:{{ \App\Models\Setting::get('store_phone', '+919876543210') }}"
                   class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-white/10 text-white font-semibold rounded-lg hover:bg-white/20 transition border border-white/20 text-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ __('shop.deepam_cta_call') }}
                </a>
            </div>

            <div class="mt-10 pt-8 border-t border-white/10">
                <a href="{{ route('upcoming-products') }}" class="text-gold-400 font-medium hover:text-gold-300 inline-flex items-center gap-2">
                    {{ __('shop.deepam_explore_more') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
