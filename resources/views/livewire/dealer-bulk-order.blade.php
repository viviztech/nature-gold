<x-dealer-layout :title="__('dealer.bulk_order')">

    <div class="flex flex-col lg:flex-row gap-6">

        {{-- Left Side: Product List --}}
        <div class="flex-1 min-w-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                {{-- Header with Search --}}
                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="font-heading text-xl font-bold text-gray-900 mb-4">{{ __('dealer.catalog') }}</h2>

                    {{-- Search Input --}}
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               placeholder="Search products..."
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none">
                    </div>
                </div>

                {{-- Product List --}}
                <div class="divide-y divide-gray-50 max-h-[600px] overflow-y-auto">
                    @forelse($products as $product)
                        <div class="px-6 py-4 hover:bg-gray-50/50 transition" wire:key="product-{{ $product->id }}">
                            <div class="flex items-center gap-4">
                                {{-- Product Image --}}
                                <div class="w-14 h-14 rounded-lg overflow-hidden bg-cream flex-shrink-0">
                                    @if($product->primaryImage)
                                        <img src="{{ Storage::url($product->primaryImage->image_path) }}"
                                             alt="{{ $product->name }}"
                                             class="w-full h-full object-cover"
                                             loading="lazy">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Product Info --}}
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-800 text-sm truncate">{{ $product->name }}</h4>
                                    <p class="text-sm font-bold text-nature-700 mt-0.5">
                                        {!! '&#8377;' !!}{{ number_format($product->dealer_price ?? $product->price, 2) }}
                                    </p>
                                    @if($product->variants && $product->variants->count() > 0)
                                        <p class="text-xs text-gray-400">{{ $product->variants->count() }} variants</p>
                                    @endif
                                </div>

                                {{-- Add Button --}}
                                <div class="flex-shrink-0">
                                    @if($product->variants && $product->variants->count() > 0)
                                        {{-- Show variant selector with Alpine --}}
                                        <div x-data="{ open: false }" class="relative">
                                            <button @click="open = !open"
                                                    class="inline-flex items-center gap-1 px-3 py-2 bg-nature-700 text-white text-xs font-semibold rounded-lg hover:bg-nature-800 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                Add
                                            </button>

                                            {{-- Variant Dropdown --}}
                                            <div x-show="open"
                                                 x-transition
                                                 @click.away="open = false"
                                                 class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-100 z-20 py-1">
                                                @foreach($product->variants as $variant)
                                                    <button wire:click="addItem({{ $product->id }}, {{ $variant->id }})"
                                                            @click="open = false"
                                                            class="w-full text-left px-4 py-2 text-sm hover:bg-gold-50 transition flex items-center justify-between">
                                                        <span class="text-gray-700">{{ $variant->name }}</span>
                                                        <span class="text-nature-700 font-semibold">{!! '&#8377;' !!}{{ number_format($variant->dealer_price ?? $variant->price, 2) }}</span>
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <button wire:click="addItem({{ $product->id }}, null)"
                                                class="inline-flex items-center gap-1 px-3 py-2 bg-nature-700 text-white text-xs font-semibold rounded-lg hover:bg-nature-800 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            Add
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 px-6">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <p class="text-sm text-gray-500">No products found.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Right Side: Order Summary Cart --}}
        <div class="lg:w-96">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gold-500 to-gold-600">
                    <h2 class="font-heading text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                        </svg>
                        {{ __('dealer.bulk_order') }}
                    </h2>
                    <p class="text-gold-100 text-sm mt-1">{{ count($items) }} item(s) in order</p>
                </div>

                {{-- Order Items --}}
                <div class="max-h-[350px] overflow-y-auto">
                    @if(count($items) > 0)
                        <div class="divide-y divide-gray-50">
                            @foreach($items as $key => $item)
                                <div class="px-4 py-3" wire:key="order-item-{{ $key }}">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-gray-800 text-sm truncate">{{ $item['name'] }}</p>
                                            @if(!empty($item['variant_name']))
                                                <p class="text-xs text-gray-500">{{ $item['variant_name'] }}</p>
                                            @endif
                                            <p class="text-xs text-nature-700 font-medium mt-0.5">{!! '&#8377;' !!}{{ number_format($item['price'], 2) }} each</p>
                                        </div>

                                        {{-- Remove Button --}}
                                        <button wire:click="removeItem('{{ $key }}')"
                                                class="p-1 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded transition flex-shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Quantity Control --}}
                                    <div class="flex items-center justify-between mt-2">
                                        <div class="flex items-center border border-gray-200 rounded-lg">
                                            <button wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] - 1 }})"
                                                    class="px-2.5 py-1 text-gray-500 hover:text-gold-600 hover:bg-gold-50 rounded-l-lg transition"
                                                    @if($item['quantity'] <= 1) disabled @endif>
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                </svg>
                                            </button>
                                            <input type="number"
                                                   wire:change="updateQuantity('{{ $key }}', $event.target.value)"
                                                   value="{{ $item['quantity'] }}"
                                                   min="1"
                                                   class="w-12 text-center text-sm font-semibold text-gray-800 border-x border-gray-200 py-1 outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                            <button wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] + 1 }})"
                                                    class="px-2.5 py-1 text-gray-500 hover:text-gold-600 hover:bg-gold-50 rounded-r-lg transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <span class="text-sm font-bold text-gray-800">
                                            {!! '&#8377;' !!}{{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Empty Cart --}}
                        <div class="text-center py-10 px-6">
                            <div class="w-14 h-14 mx-auto mb-3 bg-gold-50 rounded-full flex items-center justify-center">
                                <svg class="w-7 h-7 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500">{{ __('dealer.no_items') }}</p>
                            <p class="text-xs text-gray-400 mt-1">Add products from the list to get started.</p>
                        </div>
                    @endif
                </div>

                {{-- Order Totals & Actions --}}
                @if(count($items) > 0)
                    <div class="border-t border-gray-100 px-6 py-4">
                        {{-- Totals --}}
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-medium text-gray-800">{!! '&#8377;' !!}{{ number_format($this->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>GST</span>
                                <span class="font-medium text-gray-800">{!! '&#8377;' !!}{{ number_format($this->tax, 2) }}</span>
                            </div>
                            <div class="flex justify-between font-heading font-bold text-lg text-gray-900 pt-2 border-t border-gray-200">
                                <span>Total</span>
                                <span class="text-nature-700">{!! '&#8377;' !!}{{ number_format($this->total, 2) }}</span>
                            </div>
                        </div>

                        {{-- Order Notes --}}
                        <div class="mt-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">{{ __('dealer.order_notes') }}</label>
                            <textarea id="notes"
                                      wire:model="notes"
                                      rows="2"
                                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none resize-none"
                                      placeholder="Special instructions, delivery notes..."></textarea>
                        </div>

                        {{-- Place Order Button --}}
                        <button wire:click="placeOrder"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-75 cursor-wait"
                                class="mt-4 w-full py-3 bg-gold-500 text-white font-heading font-bold rounded-xl hover:bg-gold-600 transition shadow-sm flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="placeOrder">
                                {{ __('dealer.place_order') }}
                            </span>
                            <span wire:loading wire:target="placeOrder" class="inline-flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                    </div>
                @endif

                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="px-6 pb-4">
                        <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                            <ul class="text-sm text-red-600 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="flex items-start gap-1">
                                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>

</x-dealer-layout>
