<div class="bg-cream min-h-screen">
        <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">

            {{-- Page Header --}}
            <div class="mb-8">
                <h1 class="font-heading text-3xl md:text-4xl font-bold text-gray-900">{{ __('shop.checkout') }}</h1>
                <div class="mt-2 w-16 h-1 bg-gold-500 rounded"></div>
            </div>

            <form wire:submit="placeOrder">
                <div class="flex flex-col lg:flex-row gap-8">

                    {{-- Left Column - Shipping & Payment --}}
                    <div class="flex-1 space-y-6">

                        {{-- Shipping Address --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="font-heading text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ __('shop.shipping_address') }}
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Name --}}
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.name') }} <span class="text-red-500">*</span></label>
                                    <input type="text" id="name" wire:model="name"
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                                           placeholder="{{ __('shop.name_placeholder') }}">
                                    @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                </div>

                                {{-- Phone --}}
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.phone') }} <span class="text-red-500">*</span></label>
                                    <input type="tel" id="phone" wire:model="phone"
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                                           placeholder="{{ __('shop.phone_placeholder') }}">
                                    @error('phone') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                </div>

                                {{-- Email (shown for guests) --}}
                                @guest
                                    <div class="md:col-span-2">
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.email') }} <span class="text-red-500">*</span></label>
                                        <input type="email" id="email" wire:model="email"
                                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                                               placeholder="{{ __('shop.email_placeholder') }}">
                                        @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                @endguest

                                {{-- Address Line 1 --}}
                                <div class="md:col-span-2">
                                    <label for="address_line1" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.address_line1') }} <span class="text-red-500">*</span></label>
                                    <input type="text" id="address_line1" wire:model="address_line1"
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                                           placeholder="{{ __('shop.address_line1_placeholder') }}">
                                    @error('address_line1') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                </div>

                                {{-- Address Line 2 --}}
                                <div class="md:col-span-2">
                                    <label for="address_line2" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.address_line2') }}</label>
                                    <input type="text" id="address_line2" wire:model="address_line2"
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                                           placeholder="{{ __('shop.address_line2_placeholder') }}">
                                </div>

                                {{-- City --}}
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.city') }} <span class="text-red-500">*</span></label>
                                    <input type="text" id="city" wire:model="city"
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                                           placeholder="{{ __('shop.city_placeholder') }}">
                                    @error('city') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                </div>

                                {{-- District --}}
                                <div>
                                    <label for="district" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.district') }} <span class="text-red-500">*</span></label>
                                    <select id="district" wire:model="district"
                                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none bg-white">
                                        <option value="">{{ __('shop.select_district') }}</option>
                                        @foreach(\App\Enums\TamilNaduDistrict::cases() as $dist)
                                            <option value="{{ $dist->value }}">{{ $dist->label() }}</option>
                                        @endforeach
                                    </select>
                                    @error('district') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                </div>

                                {{-- State --}}
                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.state') }} <span class="text-red-500">*</span></label>
                                    <input type="text" id="state" wire:model="state" readonly
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm bg-gray-50 text-gray-600 outline-none">
                                </div>

                                {{-- Pincode --}}
                                <div>
                                    <label for="pincode" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.pincode') }} <span class="text-red-500">*</span></label>
                                    <input type="text" id="pincode" wire:model="pincode" maxlength="6"
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                                           placeholder="{{ __('shop.pincode_placeholder') }}">
                                    @error('pincode') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Payment Method --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="font-heading text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                {{ __('shop.payment_method') }}
                            </h2>

                            <div class="space-y-3">
                                {{-- Razorpay --}}
                                <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer transition"
                                       :class="$wire.payment_method === 'razorpay' ? 'border-gold-500 bg-gold-50' : 'border-gray-200 hover:border-gray-300'">
                                    <input type="radio" wire:model="payment_method" value="razorpay"
                                           class="w-4 h-4 text-gold-500 focus:ring-gold-500 border-gray-300">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-800">{{ __('shop.razorpay') }}</p>
                                        <p class="text-sm text-gray-500">{{ __('shop.razorpay_desc') }}</p>
                                    </div>
                                </label>

                                {{-- PhonePe --}}
                                <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer transition"
                                       :class="$wire.payment_method === 'phonepe' ? 'border-gold-500 bg-gold-50' : 'border-gray-200 hover:border-gray-300'">
                                    <input type="radio" wire:model="payment_method" value="phonepe"
                                           class="w-4 h-4 text-gold-500 focus:ring-gold-500 border-gray-300">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-800">{{ __('shop.phonepe') }}</p>
                                        <p class="text-sm text-gray-500">{{ __('shop.phonepe_desc') }}</p>
                                    </div>
                                </label>

                                {{-- COD --}}
                                <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer transition"
                                       :class="$wire.payment_method === 'cod' ? 'border-gold-500 bg-gold-50' : 'border-gray-200 hover:border-gray-300'">
                                    <input type="radio" wire:model="payment_method" value="cod"
                                           class="w-4 h-4 text-gold-500 focus:ring-gold-500 border-gray-300">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-800">{{ __('shop.cod') }}</p>
                                        <p class="text-sm text-gray-500">{{ __('shop.cod_desc') }}</p>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Right Column - Order Summary --}}
                    <div class="lg:w-96">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                            <h2 class="font-heading text-xl font-bold text-gray-900 mb-6">{{ __('shop.order_summary') }}</h2>

                            {{-- Items List --}}
                            <div class="space-y-4 max-h-64 overflow-y-auto mb-6">
                                @if($cart)
                                    @foreach($cart->items as $item)
                                        <div class="flex items-center gap-3" wire:key="checkout-item-{{ $item->id }}">
                                            <div class="w-14 h-14 rounded-lg overflow-hidden bg-cream flex-shrink-0">
                                                @if($item->product->primaryImage->first())
                                                    <img src="{{ Storage::url($item->product->primaryImage->first()->image_path) }}"
                                                         alt="{{ $item->product->name }}"
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-800 truncate">{{ $item->product->name }}</p>
                                                @if($item->variant)
                                                    <p class="text-xs text-gray-500">{{ $item->variant->name }}</p>
                                                @endif
                                                <p class="text-xs text-gray-400">{{ __('shop.qty') }}: {{ $item->quantity }}</p>
                                            </div>
                                            <span class="text-sm font-semibold text-gray-800">{{ __('shop.currency') }}{{ number_format($item->total, 0) }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            {{-- Summary Lines --}}
                            <div class="space-y-3 text-sm border-t border-gray-100 pt-4">
                                <div class="flex justify-between text-gray-600">
                                    <span>{{ __('shop.subtotal') }}</span>
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

                            {{-- Place Order Button --}}
                            <button type="submit"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-75 cursor-not-allowed"
                                    class="mt-6 w-full py-3.5 bg-nature-700 text-white font-heading font-bold rounded-xl hover:bg-nature-800 transition shadow-sm flex items-center justify-center gap-2">
                                <span wire:loading.remove>{{ __('shop.place_order') }}</span>
                                <span wire:loading>
                                    <svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </span>
                                <span wire:loading>{{ __('shop.processing') }}...</span>
                            </button>

                            {{-- Security Note --}}
                            <p class="mt-4 text-xs text-gray-400 text-center flex items-center justify-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                {{ __('shop.secure_checkout_note') }}
                            </p>
                        </div>
                    </div>

                </div>
            </form>

            @if(session('payment_error'))
                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                    {{ session('payment_error') }}
                </div>
            @endif

        </div>
    </div>

    {{-- Razorpay Checkout Script --}}
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-razorpay', ({ options }) => {
                const rzp = new Razorpay({
                    key: options.key,
                    amount: options.amount,
                    currency: options.currency,
                    name: options.name,
                    description: options.description,
                    order_id: options.order_id,
                    prefill: options.prefill,
                    theme: { color: '#D4A017' },
                    handler: function(response) {
                        // Submit payment details to callback URL
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = options.callback_url;

                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = document.querySelector('meta[name="csrf-token"]').content;
                        form.appendChild(csrf);

                        ['razorpay_payment_id', 'razorpay_order_id', 'razorpay_signature'].forEach(key => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = key;
                            input.value = response[key];
                            form.appendChild(input);
                        });

                        document.body.appendChild(form);
                        form.submit();
                    },
                    modal: {
                        ondismiss: function() {
                            // User closed the payment modal
                        }
                    }
                });
                rzp.open();
            });
        });
    </script>

</div>
