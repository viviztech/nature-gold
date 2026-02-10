<x-account-layout :title="__('shop.my_orders')">

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="font-heading text-xl font-bold text-gray-900">{{ __('shop.my_orders') }}</h2>
        </div>

        @if($orders->count() > 0)
            {{-- Orders Table (Desktop) --}}
            <div class="hidden md:block">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ __('shop.order_number') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ __('shop.date') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ __('shop.status') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ __('shop.total') }}</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ __('shop.action') }}</th>
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
                                <td class="px-6 py-4">
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
                                    <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full {{ $colorClass }}">
                                        {{ $order->status->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-800">
                                    {{ __('shop.currency') }}{{ number_format($order->total, 2) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('account.orders.show', $order) }}"
                                       class="text-sm font-medium text-gold-600 hover:text-gold-700">
                                        {{ __('shop.view_details') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Orders Cards (Mobile) --}}
            <div class="md:hidden divide-y divide-gray-100">
                @foreach($orders as $order)
                    <a href="{{ route('account.orders.show', $order) }}" class="block p-4 hover:bg-gray-50/50 transition">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-mono font-semibold text-sm text-gray-800">{{ $order->order_number }}</span>
                            @php
                                $colorClass = $statusColors[$order->status->value] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full {{ $colorClass }}">
                                {{ $order->status->label() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">{{ $order->created_at->format('d M Y') }}</span>
                            <span class="font-semibold text-gray-800">{{ __('shop.currency') }}{{ number_format($order->total, 2) }}</span>
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
                    <svg class="w-10 h-10 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <h3 class="font-heading text-lg font-bold text-gray-800 mb-2">{{ __('shop.no_orders') }}</h3>
                <p class="text-gray-500 text-sm mb-6">{{ __('shop.no_orders_message') }}</p>
                <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gold-500 text-white font-semibold rounded-lg hover:bg-gold-600 transition text-sm">
                    {{ __('shop.start_shopping') }}
                </a>
            </div>
        @endif
    </div>

</x-account-layout>
