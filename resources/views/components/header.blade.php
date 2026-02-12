<header class="bg-white shadow-sm sticky top-0 z-40" x-data="{ mobileMenu: false, searchOpen: false }">
    {{-- Top Bar (desktop) --}}
    <div class="hidden lg:flex items-center justify-between max-w-7xl mx-auto px-4 py-2 text-xs text-gray-500">
        <div class="flex items-center gap-4">
            <a href="tel:{{ \App\Models\Setting::get('store_phone', '+919876543210') }}" class="hover:text-nature-600 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                {{ \App\Models\Setting::get('store_phone', '+91 98765 43210') }}
            </a>
            <a href="mailto:{{ \App\Models\Setting::get('store_email', 'info@naturegold.in') }}" class="hover:text-nature-600">
                {{ \App\Models\Setting::get('store_email', 'info@naturegold.in') }}
            </a>
        </div>
        <div class="flex items-center gap-4">
            <livewire:language-switcher />
        </div>
    </div>

    {{-- Main Header --}}
    <div class="border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
            {{-- Mobile Menu Toggle --}}
            <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 text-gray-600 hover:text-gold-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="shrink-0">
                <img src="{{ asset('images/logos/logo.png') }}"
                     srcset="{{ asset('images/logos/logo.png') }} 1x, {{ asset('images/logos/logo@2x.png') }} 2x"
                     alt="{{ config('app.name', 'Nature Gold') }}"
                     class="h-12 sm:h-14 w-auto">
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden lg:flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-gold-600 transition {{ request()->routeIs('home') ? 'text-gold-600' : '' }}">
                    {{ __('shop.nav_home') }}
                </a>
                <a href="{{ route('shop') }}" class="text-gray-700 hover:text-gold-600 transition {{ request()->routeIs('shop*') ? 'text-gold-600' : '' }}">
                    {{ __('shop.nav_shop') }}
                </a>
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="text-gray-700 hover:text-gold-600 transition flex items-center gap-1">
                        {{ __('shop.nav_categories') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-transition class="absolute top-full left-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-100 py-2 z-50">
                        @foreach(\App\Models\Category::active()->roots()->ordered()->get() as $category)
                            <a href="{{ route('shop', ['category' => $category->slug]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gold-50 hover:text-gold-700">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-gold-600 transition {{ request()->routeIs('about') ? 'text-gold-600' : '' }}">
                    {{ __('shop.nav_about') }}
                </a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-gold-600 transition {{ request()->routeIs('contact') ? 'text-gold-600' : '' }}">
                    {{ __('shop.nav_contact') }}
                </a>
                <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-gold-600 transition {{ request()->routeIs('blog.*') ? 'text-gold-600' : '' }}">
                    {{ __('shop.nav_blog') }}
                </a>
            </nav>

            {{-- Right Actions --}}
            <div class="flex items-center gap-3">
                {{-- Search Toggle --}}
                <button @click="searchOpen = !searchOpen" class="p-2 text-gray-600 hover:text-gold-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>

                {{-- User Account --}}
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="p-2 text-gray-600 hover:text-gold-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-2 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('account.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gold-50">{{ __('shop.my_orders') }}</a>
                            <a href="{{ route('account.wishlist') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gold-50">{{ __('shop.wishlist') }}</a>
                            <a href="{{ route('account.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gold-50">{{ __('shop.profile') }}</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">{{ __('shop.logout') }}</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden lg:block p-2 text-gray-600 hover:text-gold-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </a>
                @endauth

                {{-- Cart --}}
                <livewire:cart-icon />
            </div>
        </div>

        {{-- Search Bar (dropdown) --}}
        <div x-show="searchOpen" x-transition class="border-t border-gray-100 px-4 py-3">
            <livewire:search-bar />
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenu" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="lg:hidden border-t border-gray-100 bg-white">
        <nav class="px-4 py-4 space-y-3">
            <a href="{{ route('home') }}" class="block py-2 text-gray-700 font-medium hover:text-gold-600">{{ __('shop.nav_home') }}</a>
            <a href="{{ route('shop') }}" class="block py-2 text-gray-700 font-medium hover:text-gold-600">{{ __('shop.nav_shop') }}</a>
            <div class="py-2">
                <p class="text-xs uppercase text-gray-400 font-semibold tracking-wider mb-2">{{ __('shop.nav_categories') }}</p>
                @foreach(\App\Models\Category::active()->roots()->ordered()->get() as $category)
                    <a href="{{ route('shop', ['category' => $category->slug]) }}" class="block py-1.5 pl-4 text-sm text-gray-600 hover:text-gold-600">{{ $category->name }}</a>
                @endforeach
            </div>
            <a href="{{ route('about') }}" class="block py-2 text-gray-700 font-medium hover:text-gold-600">{{ __('shop.nav_about') }}</a>
            <a href="{{ route('contact') }}" class="block py-2 text-gray-700 font-medium hover:text-gold-600">{{ __('shop.nav_contact') }}</a>
            <a href="{{ route('blog.index') }}" class="block py-2 text-gray-700 font-medium hover:text-gold-600">{{ __('shop.nav_blog') }}</a>
            @guest
                <div class="pt-3 border-t border-gray-100 flex gap-3">
                    <a href="{{ route('login') }}" class="flex-1 text-center py-2 bg-gold-500 text-white rounded-lg font-medium text-sm hover:bg-gold-600">{{ __('shop.login') }}</a>
                    <a href="{{ route('register') }}" class="flex-1 text-center py-2 border border-gold-500 text-gold-600 rounded-lg font-medium text-sm hover:bg-gold-50">{{ __('shop.register') }}</a>
                </div>
            @endguest
            <div class="pt-3 border-t border-gray-100">
                <livewire:language-switcher />
            </div>
        </nav>
    </div>
</header>
