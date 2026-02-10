<x-account-layout :title="__('shop.wishlist')">

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="font-heading text-xl font-bold text-gray-900">{{ __('shop.my_wishlist') }}</h2>
        </div>

        @if($wishlistProducts->count() > 0)
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 md:gap-6">
                    @foreach($wishlistProducts as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>

            {{-- Pagination --}}
            @if($wishlistProducts->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $wishlistProducts->links() }}
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="text-center py-16 px-6">
                <div class="w-20 h-20 mx-auto mb-4 bg-gold-50 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <h3 class="font-heading text-lg font-bold text-gray-800 mb-2">{{ __('shop.wishlist_empty') }}</h3>
                <p class="text-gray-500 text-sm mb-6">{{ __('shop.wishlist_empty_message') }}</p>
                <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gold-500 text-white font-semibold rounded-lg hover:bg-gold-600 transition text-sm">
                    {{ __('shop.browse_products') }}
                </a>
            </div>
        @endif
    </div>

</x-account-layout>
