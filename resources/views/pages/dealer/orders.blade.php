<x-dealer-layout :title="__('dealer.order_history')">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h2 class="font-heading text-xl font-bold text-gray-900">{{ __('dealer.order_history') }}</h2>
        <a href="{{ route('dealer.place-order') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gold-500 text-white font-semibold rounded-lg hover:bg-gold-600 transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            {{ __('dealer.place_order') }}
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($orders->count() > 0)
            {{-- Desktop Table --}}
            <div class="hidden md:block">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Order #</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Payment</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4">
                                    <span class="font-mono font-semibold text-sm text-gray-800">{{ $order->order_number }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $order->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $order->items_count ?? $order->items->count() }} items
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-800">
                                    {!! '&#8377;' !!}{{ number_format($order->total, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full {{ $order->status->color() }}">
                                        {{ $order->status->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full {{ $order->payment_status->color() }}">
                                        {{ $order->payment_status->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('dealer.orders.show', $order) }}"
                                       class="text-sm font-medium text-gold-600 hover:text-gold-700">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="md:hidden divide-y divide-gray-100">
                @foreach($orders as $order)
                    <a href="{{ route('dealer.orders.show', $order) }}" class="block p-4 hover:bg-gray-50/50 transition">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-mono font-semibold text-sm text-gray-800">{{ $order->order_number }}</span>
                            <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full {{ $order->status->color() }}">
                                {{ $order->status->label() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-gray-500">{{ $order->created_at->format('d M Y') }}</span>
                            <span class="font-semibold text-gray-800">{!! '&#8377;' !!}{{ number_format($order->total, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400">{{ $order->items_count ?? $order->items->count() }} items</span>
                            <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full {{ $order->payment_status->color() }}">
                                {{ $order->payment_status->label() }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $orders->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-16 px-6">
                <div class="w-20 h-20 mx-auto mb-4 bg-gold-50 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="font-heading text-lg font-bold text-gray-800 mb-2">No orders yet</h3>
                <p class="text-gray-500 text-sm mb-6">You haven't placed any orders. Start ordering from our catalog.</p>
                <a href="{{ route('dealer.place-order') }}"
                   class="inline-flex items-center gap-2 px-6 py-2.5 bg-gold-500 text-white font-semibold rounded-lg hover:bg-gold-600 transition text-sm">
                    {{ __('dealer.place_order') }}
                </a>
            </div>
        @endif
    </div>

</x-dealer-layout>
