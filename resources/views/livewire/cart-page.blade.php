<div class="bg-cream min-h-screen">
        <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">

            {{-- Page Header --}}
            <div class="mb-8">
                <h1 class="font-heading text-3xl md:text-4xl font-bold text-gray-900">{{ __('shop.cart') }}</h1>
                <div class="mt-2 w-16 h-1 bg-gold-500 rounded"></div>
            </div>

            @if($cart && $cart->items->count() > 0)
                <div class="flex flex-col lg:flex-row gap-8">

                    {{-- Cart Items --}}
                    <div class="flex-1">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            {{-- Header --}}
                            <div class="hidden md:grid md:grid-cols-12 gap-4 px-6 py-4 bg-gray-50 border-b border-gray-100 text-sm font-semibold text-gray-500 uppercase tracking-wide">
                                <div class="col-span-6">{{ __('shop.cart_product') }}</div>
                                <div class="col-span-2 text-center">{{ __('shop.cart_price') }}</div>
                                <div class="col-span-2 text-center">{{ __('shop.cart_quantity') }}</div>
                                <div class="col-span-2 text-right">{{ __('shop.cart_total') }}</div>
                            </div>

                            {{-- Items --}}
                            @foreach($cart->items as $item)
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 px-4 md:px-6 py-5 border-b border-gray-50 last:border-0 items-center" wire:key="cart-item-{{ $item->id }}">
                                    {{-- Product Info --}}
                                    <div class="md:col-span-6 flex items-center gap-4">
                                        {{-- Image --}}
                                        <div class="w-20 h-20 md:w-24 md:h-24 rounded-lg overflow-hidden bg-cream flex-shrink-0">
                                            @if($item->product->primaryImage->first())
                                                <img src="{{ Storage::url($item->product->primaryImage->first()->image_path) }}"
                                                     alt="{{ $item->product->name }}"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Name & Variant --}}
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-heading font-semibold text-gray-800 text-sm md:text-base truncate">
                                                {{ $item->product->name }}
                                            </h3>
                                            @if($item->variant)
                                                <p class="text-sm text-gray-500 mt-0.5">{{ $item->variant->name }}</p>
                                            @endif
                                            {{-- Mobile Price --}}
                                            <p class="md:hidden text-sm font-medium text-nature-700 mt-1">
                                                {{ __('shop.currency') }}{{ number_format($item->variant ? $item->variant->effective_price : $item->product->effective_price, 0) }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Unit Price (Desktop) --}}
                                    <div class="hidden md:flex md:col-span-2 justify-center items-center">
                                        <span class="font-medium text-gray-700">
                                            {{ __('shop.currency') }}{{ number_format($item->variant ? $item->variant->effective_price : $item->product->effective_price, 0) }}
                                        </span>
                                    </div>

                                    {{-- Quantity --}}
                                    <div class="md:col-span-2 flex items-center justify-between md:justify-center">
                                        <span class="md:hidden text-sm text-gray-500">{{ __('shop.cart_quantity') }}:</span>
                                        <div class="flex items-center border border-gray-200 rounded-lg">
                                            <button wire:click="decrementQuantity({{ $item->id }})"
                                                    class="px-3 py-1.5 text-gray-500 hover:text-gold-600 hover:bg-gold-50 rounded-l-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                            </button>
                                            <span class="px-4 py-1.5 text-sm font-semibold text-gray-800 min-w-[40px] text-center border-x border-gray-200">
                                                {{ $item->quantity }}
                                            </span>
                                            <button wire:click="incrementQuantity({{ $item->id }})"
                                                    class="px-3 py-1.5 text-gray-500 hover:text-gold-600 hover:bg-gold-50 rounded-r-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Line Total & Remove --}}
                                    <div class="md:col-span-2 flex items-center justify-between md:justify-end gap-3">
                                        <span class="font-bold text-gray-900">
                                            {{ __('shop.currency') }}{{ number_format($item->total, 0) }}
                                        </span>
                                        <button wire:click="removeItem({{ $item->id }})"
                                                wire:confirm="{{ __('shop.cart_remove_confirm') }}"
                                                class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Continue Shopping --}}
                        <div class="mt-6">
                            <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 text-gold-600 hover:text-gold-700 font-medium text-sm transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                {{ __('shop.continue_shopping') }}
                            </a>
                        </div>
                    </div>

                    {{-- Order Summary Sidebar --}}
                    <div class="lg:w-96">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                            <h2 class="font-heading text-xl font-bold text-gray-900 mb-6">{{ __('shop.order_summary') }}</h2>

                            {{-- Summary Lines --}}
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span>{{ __('shop.subtotal') }} ({{ $cart->item_count }} {{ __('shop.items') }})</span>
                                    <span class="font-medium text-gray-800">{{ __('shop.currency') }}{{ number_format($this->subtotal, 2) }}</span>
                                </div>

                                @if($this->discount > 0)
                                    <div class="flex justify-between text-green-600">
                                        <span>{{ __('shop.discount') }}</span>
                                        <span class="font-medium">-{{ __('shop.currency') }}{{ number_format($this->discount, 2) }}</span>
                                    </div>
                                @endif

                                <div class="flex justify-between text-gray-600">
                                    <span>{{ __('shop.shipping') }}</span>
                                    @if($this->shipping <= 0)
                                        <span class="font-medium text-green-600">{{ __('shop.free') }}</span>
                                    @else
                                        <span class="font-medium text-gray-800">{{ __('shop.currency') }}{{ number_format($this->shipping, 2) }}</span>
                                    @endif
                                </div>

                                <div class="flex justify-between text-gray-600">
                                    <span>{{ __('shop.gst') }} (5%)</span>
                                    <span class="font-medium text-gray-800">{{ __('shop.currency') }}{{ number_format($this->tax, 2) }}</span>
                                </div>

                                <div class="border-t border-gray-200 pt-3 mt-3">
                                    <div class="flex justify-between">
                                        <span class="font-heading font-bold text-lg text-gray-900">{{ __('shop.total') }}</span>
                                        <span class="font-heading font-bold text-lg text-nature-700">{{ __('shop.currency') }}{{ number_format($this->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Coupon Code --}}
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <h3 class="text-sm font-semibold text-gray-700 mb-3">{{ __('shop.coupon_code') }}</h3>

                                @if($cart->coupon_code)
                                    <div class="flex items-center justify-between bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span class="font-mono font-bold text-green-700 text-sm">{{ $cart->coupon_code }}</span>
                                        </div>
                                        <button wire:click="removeCoupon" class="text-sm text-red-500 hover:text-red-600 font-medium">{{ __('shop.remove') }}</button>
                                    </div>
                                @else
                                    <div class="flex gap-2">
                                        <input type="text"
                                               wire:model="couponCode"
                                               wire:keydown.enter="applyCoupon"
                                               placeholder="{{ __('shop.coupon_placeholder') }}"
                                               class="flex-1 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none uppercase">
                                        <button wire:click="applyCoupon"
                                                class="px-5 py-2.5 bg-gold-500 text-white text-sm font-semibold rounded-lg hover:bg-gold-600 transition">
                                            {{ __('shop.apply') }}
                                        </button>
                                    </div>
                                @endif

                                @if($couponError)
                                    <p class="mt-2 text-sm text-red-500">{{ $couponError }}</p>
                                @endif

                                @if($couponSuccess)
                                    <p class="mt-2 text-sm text-green-600">{{ $couponSuccess }}</p>
                                @endif
                            </div>

                            {{-- Free Shipping Notice --}}
                            @if($this->subtotal < 500)
                                <div class="mt-4 bg-gold-50 border border-gold-200 rounded-lg px-4 py-3">
                                    <p class="text-sm text-gold-800">
                                        {{ __('shop.free_shipping_notice', ['amount' => number_format(500 - $this->subtotal, 0)]) }}
                                    </p>
                                </div>
                            @endif

                            {{-- Checkout Button --}}
                            <a href="{{ route('checkout') }}"
                               class="mt-6 block w-full py-3.5 bg-nature-700 text-white text-center font-heading font-bold rounded-xl hover:bg-nature-800 transition shadow-sm">
                                {{ __('shop.proceed_to_checkout') }}
                            </a>

                            {{-- Trust Badges --}}
                            <div class="mt-6 flex items-center justify-center gap-4 text-gray-400">
                                <div class="flex items-center gap-1 text-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    {{ __('shop.secure_checkout') }}
                                </div>
                                <div class="flex items-center gap-1 text-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    {{ __('shop.safe_payment') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                {{-- Empty Cart State --}}
                <div class="max-w-lg mx-auto text-center py-16">
                    <div class="w-32 h-32 mx-auto mb-6 bg-gold-50 rounded-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                        </svg>
                    </div>
                    <h2 class="font-heading text-2xl font-bold text-gray-800 mb-2">{{ __('shop.cart_empty_title') }}</h2>
                    <p class="text-gray-500 mb-8">{{ __('shop.cart_empty_message') }}</p>
                    <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-gold-500 text-white font-heading font-bold rounded-xl hover:bg-gold-600 transition shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        {{ __('shop.continue_shopping') }}
                    </a>
                </div>
            @endif

        </div>
</div>
