@props(['title'])

<x-layouts.app :title="$title">

    <div class="bg-cream min-h-screen">
        <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">

            {{-- Page Header --}}
            <div class="mb-8">
                <h1 class="font-heading text-3xl md:text-4xl font-bold text-gray-900">{{ __('shop.my_account') }}</h1>
                <div class="mt-2 w-16 h-1 bg-gold-500 rounded"></div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">

                {{-- Sidebar Navigation (Desktop) --}}
                <aside class="lg:w-64 flex-shrink-0">
                    {{-- Mobile: Horizontal Tabs --}}
                    <div class="lg:hidden overflow-x-auto -mx-4 px-4 pb-2">
                        <nav class="flex gap-2 min-w-max">
                            <a href="{{ route('account.orders') }}"
                               class="px-4 py-2 text-sm font-medium rounded-lg whitespace-nowrap {{ request()->routeIs('account.orders*') ? 'bg-nature-700 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-gold-300' }}">
                                {{ __('shop.orders') }}
                            </a>
                            <a href="{{ route('account.wishlist') }}"
                               class="px-4 py-2 text-sm font-medium rounded-lg whitespace-nowrap {{ request()->routeIs('account.wishlist') ? 'bg-nature-700 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-gold-300' }}">
                                {{ __('shop.wishlist') }}
                            </a>
                            <a href="{{ route('account.addresses') }}"
                               class="px-4 py-2 text-sm font-medium rounded-lg whitespace-nowrap {{ request()->routeIs('account.addresses') ? 'bg-nature-700 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-gold-300' }}">
                                {{ __('shop.addresses') }}
                            </a>
                            <a href="{{ route('account.profile') }}"
                               class="px-4 py-2 text-sm font-medium rounded-lg whitespace-nowrap {{ request()->routeIs('account.profile') ? 'bg-nature-700 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-gold-300' }}">
                                {{ __('shop.profile') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 text-sm font-medium rounded-lg whitespace-nowrap bg-white text-red-500 border border-gray-200 hover:border-red-300">
                                    {{ __('shop.logout') }}
                                </button>
                            </form>
                        </nav>
                    </div>

                    {{-- Desktop: Vertical Sidebar --}}
                    <div class="hidden lg:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                        {{-- User Info --}}
                        <div class="p-6 bg-gradient-to-br from-nature-700 to-nature-800 text-white">
                            <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center mb-3">
                                <span class="text-xl font-heading font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            </div>
                            <p class="font-heading font-bold text-lg">{{ auth()->user()->name }}</p>
                            <p class="text-nature-200 text-sm mt-0.5">{{ auth()->user()->email }}</p>
                        </div>

                        {{-- Nav Links --}}
                        <nav class="p-3">
                            <a href="{{ route('account.orders') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('account.orders*') ? 'bg-gold-50 text-gold-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                {{ __('shop.orders') }}
                            </a>
                            <a href="{{ route('account.wishlist') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('account.wishlist') ? 'bg-gold-50 text-gold-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                {{ __('shop.wishlist') }}
                            </a>
                            <a href="{{ route('account.addresses') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('account.addresses') ? 'bg-gold-50 text-gold-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ __('shop.addresses') }}
                            </a>
                            <a href="{{ route('account.profile') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('account.profile') ? 'bg-gold-50 text-gold-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                {{ __('shop.profile') }}
                            </a>

                            <div class="border-t border-gray-100 mt-2 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-red-500 hover:bg-red-50 w-full transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
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
