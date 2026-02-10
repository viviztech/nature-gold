@props(['title'])

<x-layouts.app :title="$title">

    <div class="bg-cream min-h-screen">
        <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">

            {{-- Page Header --}}
            <div class="mb-8">
                <h1 class="font-heading text-3xl md:text-4xl font-bold text-gray-900">{{ __('dealer.dashboard') }}</h1>
                <div class="mt-2 w-16 h-1 bg-gold-500 rounded"></div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">

                {{-- Sidebar Navigation (Mobile: Horizontal Tabs) --}}
                <aside class="lg:w-64 flex-shrink-0">
                    <div class="lg:hidden overflow-x-auto -mx-4 px-4 pb-2">
                        <nav class="flex gap-2 min-w-max">
                            <a href="{{ route('dealer.dashboard') }}"
                               class="px-4 py-2 text-sm font-medium rounded-lg whitespace-nowrap {{ request()->routeIs('dealer.dashboard') ? 'bg-nature-700 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-gold-300' }}">
                                {{ __('dealer.dashboard') }}
                            </a>
                            <a href="{{ route('dealer.place-order') }}"
                               class="px-4 py-2 text-sm font-medium rounded-lg whitespace-nowrap {{ request()->routeIs('dealer.place-order') ? 'bg-nature-700 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-gold-300' }}">
                                {{ __('dealer.place_order') }}
                            </a>
                            <a href="{{ route('dealer.orders') }}"
                               class="px-4 py-2 text-sm font-medium rounded-lg whitespace-nowrap {{ request()->routeIs('dealer.orders') && !request()->routeIs('dealer.place-order') ? 'bg-nature-700 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-gold-300' }}">
                                {{ __('dealer.order_history') }}
                            </a>
                            <a href="{{ route('dealer.catalog') }}"
                               class="px-4 py-2 text-sm font-medium rounded-lg whitespace-nowrap {{ request()->routeIs('dealer.catalog') ? 'bg-nature-700 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-gold-300' }}">
                                {{ __('dealer.catalog') }}
                            </a>
                            <a href="{{ route('dealer.profile') }}"
                               class="px-4 py-2 text-sm font-medium rounded-lg whitespace-nowrap {{ request()->routeIs('dealer.profile') ? 'bg-nature-700 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-gold-300' }}">
                                {{ __('dealer.profile') }}
                            </a>
                        </nav>
                    </div>

                    {{-- Desktop: Vertical Sidebar --}}
                    <div class="hidden lg:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                        {{-- Dealer Info --}}
                        <div class="p-6 bg-gradient-to-br from-gold-600 to-gold-700 text-white">
                            <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <p class="font-heading font-bold text-lg">{{ auth()->user()->dealer->business_name }}</p>
                            <div class="mt-2">
                                @php
                                    $dealer = auth()->user()->dealer;
                                    $statusBadge = match($dealer->status->value ?? $dealer->status) {
                                        'approved', 'active' => 'bg-green-400/20 text-green-100',
                                        'pending' => 'bg-yellow-400/20 text-yellow-100',
                                        'suspended' => 'bg-red-400/20 text-red-100',
                                        default => 'bg-white/20 text-white/80',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full {{ $statusBadge }}">
                                    {{ $dealer->status->label() }}
                                </span>
                            </div>
                        </div>

                        {{-- Nav Links --}}
                        <nav class="p-3">
                            <a href="{{ route('dealer.dashboard') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('dealer.dashboard') ? 'bg-gold-50 text-gold-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                {{ __('dealer.dashboard') }}
                            </a>

                            <a href="{{ route('dealer.place-order') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('dealer.place-order') ? 'bg-gold-50 text-gold-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                {{ __('dealer.place_order') }}
                            </a>

                            <a href="{{ route('dealer.orders') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('dealer.orders') && !request()->routeIs('dealer.place-order') ? 'bg-gold-50 text-gold-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                                {{ __('dealer.order_history') }}
                            </a>

                            <a href="{{ route('dealer.catalog') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('dealer.catalog') ? 'bg-gold-50 text-gold-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                {{ __('dealer.catalog') }}
                            </a>

                            <a href="{{ route('dealer.profile') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('dealer.profile') ? 'bg-gold-50 text-gold-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ __('dealer.profile') }}
                            </a>

                            <div class="border-t border-gray-100 mt-2 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-red-500 hover:bg-red-50 w-full transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        {{ __('shop.logout') }}
                                    </button>
                                </form>
                            </div>
                        </nav>
                    </div>
                </aside>

                {{-- Main Content --}}
                <div class="flex-1 min-w-0">
                    {{ $slot }}
                </div>

            </div>
        </div>
    </div>

</x-layouts.app>
