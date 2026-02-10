<x-dealer-layout :title="__('dealer.dashboard')">

    {{-- Welcome Banner --}}
    <div class="bg-gradient-to-r from-nature-700 to-nature-800 rounded-xl p-6 mb-8 text-white">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-heading text-2xl font-bold">Welcome back, {{ $dealer->business_name }}!</h2>
                <p class="text-nature-200 mt-1 font-body">Here's an overview of your dealer account.</p>
            </div>
            <a href="{{ route('dealer.place-order') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-gold-500 text-white font-semibold rounded-lg hover:bg-gold-600 transition text-sm shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                {{ __('dealer.place_order') }}
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-8">
        {{-- Total Orders --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-gray-500">{{ __('dealer.total_orders') }}</span>
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
            <p class="font-heading text-3xl font-bold text-gray-900">{{ number_format($stats['total_orders']) }}</p>
        </div>

        {{-- Pending Orders --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-gray-500">{{ __('dealer.pending_orders') }}</span>
                <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="font-heading text-3xl font-bold text-gray-900">{{ number_format($stats['pending_orders']) }}</p>
        </div>

        {{-- Total Spent --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-gray-500">{{ __('dealer.total_spent') }}</span>
                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="font-heading text-3xl font-bold text-gray-900">{!! '&#8377;' !!}{{ number_format($stats['total_spent'], 2) }}</p>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-heading text-xl font-bold text-gray-900">{{ __('dealer.order_history') }}</h2>
            <a href="{{ route('dealer.orders') }}" class="text-sm font-medium text-gold-600 hover:text-gold-700">
                View All
            </a>
        </div>

        @if($recentOrders->count() > 0)
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
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($recentOrders as $order)
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
                @foreach($recentOrders as $order)
                    <a href="{{ route('dealer.orders.show', $order) }}" class="block p-4 hover:bg-gray-50/50 transition">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-mono font-semibold text-sm text-gray-800">{{ $order->order_number }}</span>
                            <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full {{ $order->status->color() }}">
                                {{ $order->status->label() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">{{ $order->created_at->format('d M Y') }}</span>
                            <span class="font-semibold text-gray-800">{!! '&#8377;' !!}{{ number_format($order->total, 2) }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-12 px-6">
                <div class="w-16 h-16 mx-auto mb-4 bg-gold-50 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h3 class="font-heading text-lg font-bold text-gray-800 mb-2">No orders yet</h3>
                <p class="text-gray-500 text-sm mb-6">Start by placing your first bulk order.</p>
                <a href="{{ route('dealer.place-order') }}"
                   class="inline-flex items-center gap-2 px-6 py-2.5 bg-gold-500 text-white font-semibold rounded-lg hover:bg-gold-600 transition text-sm">
                    {{ __('dealer.place_order') }}
                </a>
            </div>
        @endif
    </div>

</x-dealer-layout>
