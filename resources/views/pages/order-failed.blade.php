<x-layouts.app :title="__('shop.payment_failed')">

    <div class="min-h-[60vh] flex items-center justify-center px-4 py-16">
        <div class="max-w-lg w-full text-center">
            {{-- Failed Icon --}}
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>

            <h1 class="font-heading text-3xl font-bold text-gray-900 mb-2">{{ __('shop.payment_failed') }}</h1>
            <p class="text-gray-500 mb-6">{{ session('payment_error', __('shop.payment_failed_message')) }}</p>

            {{-- Order Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-left mb-6">
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">{{ __('shop.order_number') }}</span>
                        <span class="font-bold text-gray-900">{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">{{ __('shop.total') }}</span>
                        <span class="font-bold text-gray-900">{{ __('shop.currency') }}{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('checkout') }}"
                   class="px-6 py-3 bg-gold-500 text-white font-heading font-bold rounded-xl hover:bg-gold-600 transition">
                    {{ __('shop.try_again') }}
                </a>
                <a href="{{ route('home') }}"
                   class="px-6 py-3 border-2 border-gray-200 text-gray-700 font-heading font-bold rounded-xl hover:border-gold-300 transition">
                    {{ __('shop.go_home') }}
                </a>
            </div>

            {{-- Support --}}
            <p class="mt-6 text-sm text-gray-400">
                {{ __('shop.payment_help') }}
                <a href="https://wa.me/{{ config('app.whatsapp_number', '919876543210') }}" target="_blank" class="text-green-600 hover:underline font-medium">WhatsApp</a>
            </p>
        </div>
    </div>

</x-layouts.app>
