<x-dealer-layout :title="'Order ' . $order->order_number">

    {{-- Back Link --}}
    <div class="mb-6">
        <a href="{{ route('dealer.orders') }}" class="inline-flex items-center gap-1 text-sm text-gold-600 hover:text-gold-700 font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Orders
        </a>
    </div>

    {{-- Order Header --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-heading text-xl font-bold text-gray-900">{{ $order->order_number }}</h2>
                <p class="text-sm text-gray-500 mt-1">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <div class="flex items-center gap-3 flex-wrap">
                <span class="inline-flex px-3 py-1.5 text-sm font-semibold rounded-full {{ $order->status->color() }}">
                    {{ $order->status->label() }}
                </span>
                <span class="inline-flex px-3 py-1.5 text-sm font-semibold rounded-full {{ $order->payment_status->color() }}">
                    {{ $order->payment_status->label() }}
                </span>

                {{-- Invoice Download --}}
                @if($order->invoice_path)
                    <a href="{{ route('dealer.orders.invoice', $order) }}"
                       class="inline-flex items-center gap-2 px-4 py-1.5 bg-nature-700 text-white text-sm font-semibold rounded-lg hover:bg-nature-800 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download Invoice
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Order Items --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-heading font-bold text-gray-900">Order Items</h3>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden md:block">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Product</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Qty</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Unit Price</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-lg overflow-hidden bg-cream flex-shrink-0">
                                        @if($item->product?->primaryImage)
                                            <img src="{{ Storage::url($item->product->primaryImage->image_path) }}"
                                                 alt="{{ $item->product_name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">{{ $item->product_name }}</p>
                                        @if($item->variant_name)
                                            <p class="text-xs text-gray-500">{{ $item->variant_name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-gray-600">
                                {!! '&#8377;' !!}{{ number_format($item->unit_price, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-semibold text-gray-800">
                                {!! '&#8377;' !!}{{ number_format($item->total, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile Items --}}
        <div class="md:hidden divide-y divide-gray-50">
            @foreach($order->items as $item)
                <div class="flex items-center gap-4 px-4 py-4">
                    <div class="w-14 h-14 rounded-lg overflow-hidden bg-cream flex-shrink-0">
                        @if($item->product?->primaryImage)
                            <img src="{{ Storage::url($item->product->primaryImage->image_path) }}"
                                 alt="{{ $item->product_name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 text-sm">{{ $item->product_name }}</p>
                        @if($item->variant_name)
                            <p class="text-xs text-gray-500">{{ $item->variant_name }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-1">Qty: {{ $item->quantity }} x {!! '&#8377;' !!}{{ number_format($item->unit_price, 2) }}</p>
                    </div>
                    <span class="font-bold text-gray-900 text-sm">{!! '&#8377;' !!}{{ number_format($item->total, 2) }}</span>
                </div>
            @endforeach
        </div>

        {{-- Pricing Summary --}}
        <div class="bg-gray-50 px-6 py-4 space-y-2 text-sm">
            <div class="flex justify-between text-gray-600">
                <span>Subtotal</span>
                <span>{!! '&#8377;' !!}{{ number_format($order->subtotal, 2) }}</span>
            </div>
            @if($order->discount > 0)
                <div class="flex justify-between text-green-600">
                    <span>Discount</span>
                    <span>-{!! '&#8377;' !!}{{ number_format($order->discount, 2) }}</span>
                </div>
            @endif
            @if($order->shipping_cost > 0)
                <div class="flex justify-between text-gray-600">
                    <span>Shipping</span>
                    <span>{!! '&#8377;' !!}{{ number_format($order->shipping_cost, 2) }}</span>
                </div>
            @else
                <div class="flex justify-between text-gray-600">
                    <span>Shipping</span>
                    <span class="text-green-600">Free</span>
                </div>
            @endif
            <div class="flex justify-between text-gray-600">
                <span>GST</span>
                <span>{!! '&#8377;' !!}{{ number_format($order->tax, 2) }}</span>
            </div>
            <div class="flex justify-between font-heading font-bold text-lg text-gray-900 pt-2 border-t border-gray-200">
                <span>Total</span>
                <span class="text-nature-700">{!! '&#8377;' !!}{{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Shipping Address & Payment Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Shipping Address --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-heading font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Shipping Address
            </h3>
            @if($order->shipping_address)
                <div class="text-sm text-gray-600 space-y-1">
                    <p class="font-semibold text-gray-800">{{ $order->shipping_address['name'] ?? '' }}</p>
                    @if(!empty($order->shipping_address['phone']))
                        <p>{{ $order->shipping_address['phone'] }}</p>
                    @endif
                    <p>{{ $order->shipping_address['line1'] ?? '' }}</p>
                    @if(!empty($order->shipping_address['line2']))
                        <p>{{ $order->shipping_address['line2'] }}</p>
                    @endif
                    <p>{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['district'] ?? '' }}</p>
                    <p>{{ $order->shipping_address['state'] ?? '' }} - {{ $order->shipping_address['pincode'] ?? '' }}</p>
                </div>
            @else
                <p class="text-sm text-gray-500">No shipping address on file.</p>
            @endif
        </div>

        {{-- Payment Info --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-heading font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Payment Information
            </h3>
            <div class="text-sm space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-500">Payment Method</span>
                    <span class="font-medium text-gray-800">{{ $order->payment_method->label() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Payment Status</span>
                    <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full {{ $order->payment_status->color() }}">
                        {{ $order->payment_status->label() }}
                    </span>
                </div>
                @if($order->payment_id)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Transaction ID</span>
                        <span class="font-mono text-xs font-medium text-gray-800">{{ $order->payment_id }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Order Notes --}}
    @if($order->notes)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-heading font-bold text-gray-900 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                {{ __('dealer.order_notes') }}
            </h3>
            <p class="text-sm text-gray-600">{{ $order->notes }}</p>
        </div>
    @endif

</x-dealer-layout>
