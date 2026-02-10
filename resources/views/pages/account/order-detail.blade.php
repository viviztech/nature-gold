<x-account-layout :title="__('shop.order_detail') . ' - ' . $order->order_number">

    {{-- Back Link --}}
    <div class="mb-6">
        <a href="{{ route('account.orders') }}" class="inline-flex items-center gap-1 text-sm text-gold-600 hover:text-gold-700 font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            {{ __('shop.back_to_orders') }}
        </a>
    </div>

    {{-- Order Header --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-heading text-xl font-bold text-gray-900">{{ $order->order_number }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ __('shop.placed_on') }} {{ $order->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <div class="flex items-center gap-3">
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        'confirmed' => 'bg-blue-100 text-blue-700',
                        'processing' => 'bg-indigo-100 text-indigo-700',
                        'shipped' => 'bg-cyan-100 text-cyan-700',
                        'delivered' => 'bg-green-100 text-green-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                        'returned' => 'bg-gray-100 text-gray-700',
                    ];
                    $colorClass = $statusColors[$order->status->value] ?? 'bg-gray-100 text-gray-700';
                @endphp
                <span class="inline-flex px-3 py-1.5 text-sm font-semibold rounded-full {{ $colorClass }}">
                    {{ $order->status->label() }}
                </span>
            </div>
        </div>
    </div>

    {{-- Order Timeline --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="font-heading font-bold text-gray-900 mb-6">{{ __('shop.order_timeline') }}</h3>
        <div class="flex items-center justify-between overflow-x-auto pb-2">
            @php
                $steps = [
                    ['status' => 'pending', 'label' => __('shop.status_placed'), 'date' => $order->created_at],
                    ['status' => 'confirmed', 'label' => __('shop.status_confirmed'), 'date' => $order->confirmed_at],
                    ['status' => 'shipped', 'label' => __('shop.status_shipped'), 'date' => $order->shipped_at],
                    ['status' => 'delivered', 'label' => __('shop.status_delivered'), 'date' => $order->delivered_at],
                ];
                $statusOrder = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
                $currentIndex = array_search($order->status->value, $statusOrder);
                if ($currentIndex === false) $currentIndex = -1;
            @endphp

            @foreach($steps as $index => $step)
                <div class="flex flex-col items-center min-w-[80px] relative">
                    {{-- Step Circle --}}
                    <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 z-10
                        {{ $index <= $currentIndex ? 'bg-nature-700 border-nature-700 text-white' : 'bg-white border-gray-300 text-gray-400' }}">
                        @if($index < $currentIndex)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @elseif($index === $currentIndex)
                            <div class="w-3 h-3 bg-white rounded-full"></div>
                        @else
                            <span class="text-xs font-bold">{{ $index + 1 }}</span>
                        @endif
                    </div>
                    <p class="text-xs font-medium mt-2 text-center {{ $index <= $currentIndex ? 'text-nature-700' : 'text-gray-400' }}">{{ $step['label'] }}</p>
                    @if($step['date'])
                        <p class="text-xs text-gray-400 mt-0.5">{{ $step['date']->format('d M') }}</p>
                    @endif
                </div>

                @if(! $loop->last)
                    <div class="flex-1 h-0.5 mt-5 mx-1 {{ $index < $currentIndex ? 'bg-nature-700' : 'bg-gray-200' }}"></div>
                @endif
            @endforeach
        </div>

        {{-- Tracking Info --}}
        @if($order->tracking_number)
            <div class="mt-6 pt-4 border-t border-gray-100 flex items-center gap-3">
                <span class="text-sm text-gray-500">{{ __('shop.tracking') }}:</span>
                <span class="font-mono text-sm font-semibold text-gray-800">{{ $order->tracking_number }}</span>
                @if($order->tracking_url)
                    <a href="{{ $order->tracking_url }}" target="_blank" class="text-sm text-gold-600 hover:text-gold-700 font-medium">{{ __('shop.track_order') }}</a>
                @endif
            </div>
        @endif
    </div>

    {{-- Order Items --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-heading font-bold text-gray-900">{{ __('shop.order_items') }}</h3>
        </div>

        <div class="divide-y divide-gray-50">
            @foreach($order->items as $item)
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="w-16 h-16 rounded-lg overflow-hidden bg-cream flex-shrink-0">
                        @if($item->product?->primaryImage->first())
                            <img src="{{ Storage::url($item->product->primaryImage->first()->image_path) }}"
                                 alt="{{ $item->product_name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 text-sm">{{ $item->product_name }}</p>
                        @if($item->variant_name)
                            <p class="text-xs text-gray-500">{{ $item->variant_name }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-1">{{ __('shop.qty') }}: {{ $item->quantity }} x {{ __('shop.currency') }}{{ number_format($item->unit_price, 2) }}</p>
                    </div>
                    <span class="font-bold text-gray-900 text-sm">{{ __('shop.currency') }}{{ number_format($item->total, 2) }}</span>
                </div>
            @endforeach
        </div>

        {{-- Order Totals --}}
        <div class="bg-gray-50 px-6 py-4 space-y-2 text-sm">
            <div class="flex justify-between text-gray-600">
                <span>{{ __('shop.subtotal') }}</span>
                <span>{{ __('shop.currency') }}{{ number_format($order->subtotal, 2) }}</span>
            </div>
            @if($order->discount > 0)
                <div class="flex justify-between text-green-600">
                    <span>{{ __('shop.discount') }} @if($order->coupon_code)({{ $order->coupon_code }})@endif</span>
                    <span>-{{ __('shop.currency') }}{{ number_format($order->discount, 2) }}</span>
                </div>
            @endif
            <div class="flex justify-between text-gray-600">
                <span>{{ __('shop.shipping') }}</span>
                @if($order->shipping_cost <= 0)
                    <span class="text-green-600">{{ __('shop.free') }}</span>
                @else
                    <span>{{ __('shop.currency') }}{{ number_format($order->shipping_cost, 2) }}</span>
                @endif
            </div>
            <div class="flex justify-between text-gray-600">
                <span>{{ __('shop.gst') }}</span>
                <span>{{ __('shop.currency') }}{{ number_format($order->tax, 2) }}</span>
            </div>
            <div class="flex justify-between font-heading font-bold text-lg text-gray-900 pt-2 border-t border-gray-200">
                <span>{{ __('shop.total') }}</span>
                <span class="text-nature-700">{{ __('shop.currency') }}{{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Shipping & Payment Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Shipping Address --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-heading font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ __('shop.shipping_address') }}
            </h3>
            @if($order->shipping_address)
                <div class="text-sm text-gray-600 space-y-1">
                    <p class="font-semibold text-gray-800">{{ $order->shipping_address['name'] ?? '' }}</p>
                    <p>{{ $order->shipping_address['phone'] ?? '' }}</p>
                    <p>{{ $order->shipping_address['line1'] ?? '' }}</p>
                    @if(! empty($order->shipping_address['line2']))
                        <p>{{ $order->shipping_address['line2'] }}</p>
                    @endif
                    <p>{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['district'] ?? '' }}</p>
                    <p>{{ $order->shipping_address['state'] ?? '' }} - {{ $order->shipping_address['pincode'] ?? '' }}</p>
                </div>
            @endif
        </div>

        {{-- Payment Info --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-heading font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                {{ __('shop.payment_info') }}
            </h3>
            <div class="text-sm space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('shop.payment_method') }}</span>
                    <span class="font-medium text-gray-800">{{ $order->payment_method->label() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('shop.payment_status') }}</span>
                    @php
                        $payColors = [
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'paid' => 'bg-green-100 text-green-700',
                            'failed' => 'bg-red-100 text-red-700',
                            'refunded' => 'bg-blue-100 text-blue-700',
                        ];
                        $payColor = $payColors[$order->payment_status->value] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full {{ $payColor }}">
                        {{ $order->payment_status->label() }}
                    </span>
                </div>
            </div>
        </div>
    </div>

</x-account-layout>
