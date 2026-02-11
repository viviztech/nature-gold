<x-layouts.app
    :title="$productTypeName . ' ' . __('shop.in') . ' ' . $districtName"
    :metaDescription="__('shop.local_product_meta', ['product' => $productTypeName, 'district' => $districtName])"
    :jsonLd="$jsonLd"
>
    {{-- Hero --}}
    <section class="bg-gradient-to-br from-gold-600 to-gold-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="text-gold-200 text-sm mb-4">
                <a href="{{ route('home') }}" class="hover:text-white">{{ __('shop.nav_home') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('local.index') }}" class="hover:text-white">{{ __('shop.local_landing_title') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('local.show', $district) }}" class="hover:text-white">{{ $districtName }}</a>
                <span class="mx-2">/</span>
                <span class="text-white">{{ $productTypeName }}</span>
            </nav>
            <h1 class="font-heading text-3xl md:text-4xl font-bold mb-4">
                {{ __('shop.local_product_hero', ['product' => $productTypeName, 'district' => $districtName]) }}
            </h1>
            <p class="text-gold-100 text-lg max-w-2xl">
                {{ __('shop.local_product_subtitle', ['product' => $productTypeName, 'district' => $districtName]) }}
            </p>
        </div>
    </section>

    {{-- Products --}}
    <section class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="font-heading text-2xl font-bold text-gray-900 mb-6">
            {{ __('shop.local_browse_products', ['product' => $productTypeName]) }}
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('shop') }}" class="inline-block px-8 py-3 bg-gold-500 text-white font-semibold rounded-xl hover:bg-gold-600 transition">
                {{ __('shop.view_all_products') }}
            </a>
        </div>
    </section>

    {{-- Info Section --}}
    <section class="bg-cream py-12">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="font-heading text-2xl font-bold text-gray-900 mb-6">
                {{ __('shop.local_about_product', ['product' => $productTypeName]) }}
            </h2>
            <div class="prose prose-gray max-w-none">
                <p>{{ __('shop.local_product_desc_1', ['product' => $productTypeName, 'district' => $districtName]) }}</p>
                <p>{{ __('shop.local_product_desc_2', ['product' => $productTypeName]) }}</p>
            </div>
        </div>
    </section>

    {{-- Back to District --}}
    <section class="max-w-7xl mx-auto px-4 py-8">
        <a href="{{ route('local.show', $district) }}" class="inline-flex items-center text-nature-700 hover:text-nature-900 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            {{ __('shop.local_back_to_district', ['district' => $districtName]) }}
        </a>
    </section>

</x-layouts.app>
