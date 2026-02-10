<x-layouts.app :title="__('shop.order_confirmed')">

    <div class="min-h-[60vh] flex items-center justify-center px-4 py-16">
        <div class="max-w-lg w-full text-center">
            {{-- Success Icon --}}
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="font-heading text-3xl font-bold text-gray-900 mb-2">{{ __('shop.order_confirmed') }}</h1>
            <p class="text-gray-500 mb-6">{{ __('shop.order_confirmed_message') }}</p>

            {{-- Order Details Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-left mb-6">
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">{{ __('shop.order_number') }}</span>
                        <span class="font-bold text-gray-900">{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">{{ __('shop.payment_method') }}</span>
                        <span class="font-medium text-gray-800">{{ $order->payment_method->label() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">{{ __('shop.payment_status') }}</span>
                        <span class="px-2 py-0.5 rounded text-xs font-bold {{ $order->payment_status === \App\Enums\PaymentStatus::Paid ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $order->payment_status->label() }}
                        </span>
                    </div>
                    <div class="border-t pt-3 flex justify-between">
                        <span class="font-heading font-bold text-gray-900">{{ __('shop.total') }}</span>
                        <span class="font-heading font-bold text-nature-700">{{ __('shop.currency') }}{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="bg-gray-50 rounded-xl p-4 text-left text-sm text-gray-600 mb-6">
                <p class="font-medium text-gray-800 mb-1">{{ __('shop.shipping_address') }}</p>
                <p>{{ $order->shipping_address['name'] ?? '' }}</p>
                <p>{{ $order->shipping_address['line1'] ?? '' }}</p>
                @if($order->shipping_address['line2'] ?? '')
                    <p>{{ $order->shipping_address['line2'] }}</p>
                @endif
                <p>{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['district'] ?? '' }}</p>
                <p>{{ $order->shipping_address['state'] ?? '' }} - {{ $order->shipping_address['pincode'] ?? '' }}</p>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                @auth
                    <a href="{{ route('account.orders.show', $order) }}"
                       class="px-6 py-3 bg-gold-500 text-white font-heading font-bold rounded-xl hover:bg-gold-600 transition">
                        {{ __('shop.view_order') }}
                    </a>
                @endauth
                <a href="{{ route('shop') }}"
                   class="px-6 py-3 border-2 border-gray-200 text-gray-700 font-heading font-bold rounded-xl hover:border-gold-300 transition">
                    {{ __('shop.continue_shopping') }}
                </a>
            </div>

            {{-- WhatsApp Share --}}
            <div class="mt-6">
                <a href="https://wa.me/?text={{ urlencode(__('shop.order_whatsapp_share', ['number' => $order->order_number, 'total' => number_format($order->total, 2)])) }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 text-sm text-green-600 hover:text-green-700 font-medium">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    {{ __('shop.share_order_whatsapp') }}
                </a>
            </div>
        </div>
    </div>

</x-layouts.app>
