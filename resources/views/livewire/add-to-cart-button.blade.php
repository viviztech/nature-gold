<div class="mt-3">
    @if($product->variants->count() > 1)
        <select wire:model="variantId" class="w-full mb-2 px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:border-gold-400 focus:ring-1 focus:ring-gold-200 outline-none">
            @foreach($product->variants as $variant)
                <option value="{{ $variant->id }}">{{ $variant->name }} - ₹{{ number_format($variant->effective_price, 0) }}</option>
            @endforeach
        </select>
    @endif

    <button wire:click="addToCart"
            wire:loading.attr="disabled"
            class="w-full py-2.5 rounded-lg text-sm font-semibold transition {{ $added ? 'bg-nature-600 text-white' : 'bg-gold-500 text-white hover:bg-gold-600' }} disabled:opacity-50">
        <span wire:loading.remove>
            @if($added)
                <span class="flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ __('shop.added_to_cart') }}
                </span>
            @else
                {{ __('shop.add_to_cart') }}
            @endif
        </span>
        <span wire:loading class="flex items-center justify-center gap-2">
            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
            {{ __('shop.adding') }}
        </span>
    </button>
</div>
