<x-layouts.app :title="__('shop.upcoming_products_title')">

    {{-- Hero Slider --}}
    @if($banners->count() > 0)
    <section x-data="{ current: 0, total: {{ $banners->count() }} }"
             x-init="setInterval(() => current = (current + 1) % total, 5000)"
             class="relative overflow-hidden h-[400px] md:h-[500px] lg:h-[600px]">
        @foreach($banners as $index => $banner)
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                 :class="current === {{ $index }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                <picture>
                    @if($banner->mobile_image)
                        <source media="(max-width: 768px)" srcset="{{ Storage::url($banner->mobile_image) }}">
                    @endif
                    <img src="{{ Storage::url($banner->image) }}"
                         alt="{{ $banner->title }}"
                         class="w-full h-full object-cover">
                </picture>
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent flex items-center">
                    <div class="max-w-7xl mx-auto px-4 w-full">
                        <div class="max-w-lg">
                            @if($banner->subtitle)
                                <p class="text-gold-300 text-sm md:text-base font-medium uppercase tracking-wider mb-2">{{ $banner->subtitle }}</p>
                            @endif
                            @if($banner->title)
                                <h2 class="font-heading text-3xl md:text-5xl font-bold text-white leading-tight">{{ $banner->title }}</h2>
                            @endif
                            @if($banner->button_text)
                                <a href="{{ $banner->link ?? route('shop') }}" class="inline-block mt-6 px-8 py-3 bg-gold-500 text-white font-semibold rounded-lg hover:bg-gold-600 transition shadow-lg">
                                    {{ $banner->button_text }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Slider Dots --}}
        @if($banners->count() > 1)
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-20">
            @foreach($banners as $index => $banner)
                <button @click="current = {{ $index }}"
                        :class="current === {{ $index }} ? 'bg-gold-500 w-8' : 'bg-white/60 w-3'"
                        class="h-3 rounded-full transition-all duration-300"></button>
            @endforeach
        </div>
        @endif
    </section>
    @endif

    {{-- Categories --}}
    @if($categories->count() > 0)
    <section class="max-w-7xl mx-auto px-4 py-16">
        <div class="text-center mb-10">
            <h2 class="font-heading text-3xl font-bold text-gray-900">{{ __('shop.shop_categories') }}</h2>
            <div class="mt-2 w-16 h-1 bg-gold-500 mx-auto rounded"></div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('shop', ['category' => $category->slug]) }}" class="group relative overflow-hidden rounded-xl aspect-square">
                    @if($category->image)
                        <img src="{{ Storage::url($category->image) }}"
                             alt="{{ $category->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             loading="lazy">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-gold-100 to-nature-100"></div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex items-end p-4">
                        <div>
                            <h3 class="font-heading text-lg font-bold text-white">{{ $category->name }}</h3>
                            <p class="text-gold-300 text-sm mt-0.5">{{ $category->products_count }} {{ __('shop.all_products') }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Featured Products --}}
    @if($featuredProducts->count() > 0)
    <section class="bg-cream py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="font-heading text-3xl font-bold text-gray-900">{{ __('shop.featured_products') }}</h2>
                    <div class="mt-2 w-16 h-1 bg-gold-500 rounded"></div>
                </div>
                <a href="{{ route('shop') }}" class="text-gold-600 font-medium hover:text-gold-700 text-sm flex items-center gap-1">
                    {{ __('shop.view_all') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Why Nature Gold (USP Section) --}}
    <section class="max-w-7xl mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="font-heading text-3xl font-bold text-gray-900">{{ __('shop.why_nature_gold') }}</h2>
            <div class="mt-2 w-16 h-1 bg-gold-500 mx-auto rounded"></div>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            <div class="text-center p-6 rounded-xl bg-white shadow-sm border border-gray-100">
                <div class="w-16 h-16 mx-auto bg-nature-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-nature-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <h3 class="font-heading font-bold text-gray-900">{{ __('shop.usp_natural') }}</h3>
                <p class="text-sm text-gray-500 mt-2">{{ __('shop.usp_natural_desc') }}</p>
            </div>
            <div class="text-center p-6 rounded-xl bg-white shadow-sm border border-gray-100">
                <div class="w-16 h-16 mx-auto bg-gold-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <h3 class="font-heading font-bold text-gray-900">{{ __('shop.usp_coldpressed') }}</h3>
                <p class="text-sm text-gray-500 mt-2">{{ __('shop.usp_coldpressed_desc') }}</p>
            </div>
            <div class="text-center p-6 rounded-xl bg-white shadow-sm border border-gray-100">
                <div class="w-16 h-16 mx-auto bg-nature-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-nature-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-heading font-bold text-gray-900">{{ __('shop.usp_farm') }}</h3>
                <p class="text-sm text-gray-500 mt-2">{{ __('shop.usp_farm_desc') }}</p>
            </div>
            <div class="text-center p-6 rounded-xl bg-white shadow-sm border border-gray-100">
                <div class="w-16 h-16 mx-auto bg-gold-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-heading font-bold text-gray-900">{{ __('shop.usp_lab') }}</h3>
                <p class="text-sm text-gray-500 mt-2">{{ __('shop.usp_lab_desc') }}</p>
            </div>
        </div>
    </section>

    {{-- Best Sellers --}}
    @if($bestSellers->count() > 0)
    <section class="bg-nature-900 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="font-heading text-3xl font-bold text-white">{{ __('shop.best_sellers') }}</h2>
                    <div class="mt-2 w-16 h-1 bg-gold-500 rounded"></div>
                </div>
                <a href="{{ route('shop', ['sort' => 'popular']) }}" class="text-gold-400 font-medium hover:text-gold-300 text-sm flex items-center gap-1">
                    {{ __('shop.view_all') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($bestSellers as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

</x-layouts.app>
