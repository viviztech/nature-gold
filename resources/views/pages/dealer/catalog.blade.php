<x-dealer-layout :title="__('dealer.catalog')">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="font-heading text-xl font-bold text-gray-900">{{ __('dealer.catalog') }}</h2>
            <p class="text-sm text-gray-500 mt-1">Browse products with your exclusive dealer pricing.</p>
        </div>
        <a href="{{ route('dealer.place-order') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gold-500 text-white font-semibold rounded-lg hover:bg-gold-600 transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            {{ __('dealer.bulk_order') }}
        </a>
    </div>

    {{-- Product Grid --}}
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @foreach($products as $product)
                @php
                    $dealerPrice = $dealerPricing[$product->id] ?? null;
                    $minQty = $minQuantities[$product->id] ?? null;
                    $regularPrice = $product->sale_price && $product->sale_price < $product->price ? $product->sale_price : $product->price;
                @endphp

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-all duration-300">
                    {{-- Product Image --}}
                    <a href="{{ route('product.show', $product->slug) }}" class="block relative overflow-hidden aspect-square">
                        @if($product->primaryImage)
                            <img src="{{ Storage::url($product->primaryImage->image_path) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full bg-cream flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Dealer Price Badge --}}
                        @if($dealerPrice)
                            <div class="absolute top-2 left-2">
                                <span class="px-2 py-0.5 bg-gold-500 text-white text-xs font-bold rounded">
                                    {{ __('dealer.dealer_price') }}
                                </span>
                            </div>
                        @endif
                    </a>

                    {{-- Product Details --}}
                    <div class="p-4">
                        <p class="text-xs text-gray-400 uppercase tracking-wide">{{ $product->category?->name }}</p>
                        <h3 class="font-heading font-semibold text-gray-800 mt-1 line-clamp-2 group-hover:text-gold-700 transition">
                            {{ $product->name }}
                        </h3>

                        {{-- Pricing --}}
                        <div class="mt-3">
                            @if($dealerPrice)
                                <div class="flex items-baseline gap-2">
                                    <span class="text-lg font-bold text-nature-700">
                                        {!! '&#8377;' !!}{{ number_format($dealerPrice, 2) }}
                                    </span>
                                    <span class="text-sm text-gray-400 line-through">
                                        {{ __('dealer.regular_price') }}: {!! '&#8377;' !!}{{ number_format($regularPrice, 2) }}
                                    </span>
                                </div>
                                @php
                                    $savings = $regularPrice - $dealerPrice;
                                    $savingsPercent = $regularPrice > 0 ? round(($savings / $regularPrice) * 100) : 0;
                                @endphp
                                @if($savings > 0)
                                    <p class="text-xs text-green-600 font-medium mt-1">
                                        You save {!! '&#8377;' !!}{{ number_format($savings, 2) }} ({{ $savingsPercent }}%)
                                    </p>
                                @endif
                            @else
                                <span class="text-lg font-bold text-nature-700">
                                    {!! '&#8377;' !!}{{ number_format($regularPrice, 2) }}
                                </span>
                            @endif
                        </div>

                        {{-- Min Quantity --}}
                        @if($minQty)
                            <div class="mt-2 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-xs text-gray-500">{{ __('dealer.min_qty') }}: {{ $minQty }}</span>
                            </div>
                        @endif

                        {{-- Variants info --}}
                        @if($product->variants && $product->variants->count() > 0)
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $product->variants->count() }} variants available
                            </p>
                        @endif

                        {{-- Add to Order Button --}}
                        <a href="{{ route('dealer.place-order') }}?product={{ $product->id }}"
                           class="mt-4 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-nature-700 text-white text-sm font-semibold rounded-lg hover:bg-nature-800 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            {{ __('dealer.add_to_order') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 text-center py-16 px-6">
            <div class="w-20 h-20 mx-auto mb-4 bg-gold-50 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
            </div>
            <h3 class="font-heading text-lg font-bold text-gray-800 mb-2">No products available</h3>
            <p class="text-gray-500 text-sm">The product catalog is currently empty. Check back later.</p>
        </div>
    @endif

</x-dealer-layout>
