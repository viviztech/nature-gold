@props(['product'])

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-all duration-300">
    {{-- Image --}}
    <a href="{{ route('product.show', $product->slug) }}" class="block relative overflow-hidden aspect-square">
        @if($product->primaryImage)
            <img src="{{ Storage::url($product->primaryImage->image_path) }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                 loading="lazy">
        @else
            <div class="w-full h-full bg-cream flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        @endif

        {{-- Badges --}}
        <div class="absolute top-2 left-2 flex flex-col gap-1">
            @if($product->sale_price && $product->sale_price < $product->price)
                <span class="px-2 py-0.5 bg-red-500 text-white text-xs font-bold rounded">
                    -{{ $product->discount_percentage }}%
                </span>
            @endif
            @if($product->is_featured)
                <span class="px-2 py-0.5 bg-gold-500 text-white text-xs font-bold rounded">
                    {{ __('shop.featured') }}
                </span>
            @endif
        </div>

        {{-- Wishlist --}}
        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
            <livewire:wishlist-button :productId="$product->id" :wire:key="'wish-card-'.$product->id" />
        </div>
    </a>

    {{-- Details --}}
    <div class="p-4">
        <a href="{{ route('product.show', $product->slug) }}" class="block">
            <p class="text-xs text-gray-400 uppercase tracking-wide">{{ $product->category?->name }}</p>
            <h3 class="font-heading font-semibold text-gray-800 mt-1 line-clamp-2 group-hover:text-gold-700 transition">
                {{ $product->name }}
            </h3>
        </a>

        {{-- Price --}}
        <div class="mt-2 flex items-baseline gap-2">
            <span class="text-lg font-bold text-nature-700">
                ₹{{ number_format($product->effective_price, 0) }}
            </span>
            @if($product->sale_price && $product->sale_price < $product->price)
                <span class="text-sm text-gray-400 line-through">₹{{ number_format($product->price, 0) }}</span>
            @endif
        </div>

        {{-- Variants hint --}}
        @if($product->variants->count() > 0)
            <p class="text-xs text-gray-400 mt-1">
                {{ $product->variants->count() }} {{ __('shop.sizes_available') }}
            </p>
        @endif

        {{-- Add to Cart --}}
        <livewire:add-to-cart-button :product="$product" :wire:key="'atc-'.$product->id" />
    </div>
</div>
