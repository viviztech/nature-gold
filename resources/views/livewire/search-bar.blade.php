<div class="relative max-w-2xl mx-auto">
    <form wire:submit="search" class="relative">
        <input type="text"
               wire:model.live.debounce.300ms="query"
               placeholder="{{ __('shop.search_placeholder') }}"
               class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 outline-none text-sm">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    </form>

    {{-- Results Dropdown --}}
    @if(strlen($query) >= 2 && count($results) > 0)
        <div class="absolute top-full mt-2 w-full bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden">
            @foreach($results as $product)
                <a href="{{ route('product.show', $product->slug) }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gold-50 transition" wire:navigate>
                    @if($product->primaryImage)
                        <img src="{{ Storage::url($product->primaryImage->image_path) }}" class="w-10 h-10 rounded object-cover" alt="">
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $product->name }}</p>
                        <p class="text-xs text-nature-600 font-semibold">₹{{ number_format($product->effective_price, 0) }}</p>
                    </div>
                </a>
            @endforeach
            <a href="{{ route('shop', ['search' => $query]) }}" class="block text-center py-2 text-sm text-gold-600 font-medium hover:bg-gold-50 border-t border-gray-100" wire:navigate>
                {{ __('shop.view_all_results') }}
            </a>
        </div>
    @endif
</div>
