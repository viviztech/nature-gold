{{-- Sticky Mobile Bottom Navigation --}}
<nav class="lg:hidden fixed bottom-0 inset-x-0 bg-white border-t border-gray-200 z-50 safe-area-bottom">
    <div class="grid grid-cols-4 h-16">
        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center gap-0.5 {{ request()->routeIs('home') ? 'text-gold-600' : 'text-gray-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span class="text-[10px] font-medium">{{ __('shop.nav_home') }}</span>
        </a>

        <a href="{{ route('shop') }}" class="flex flex-col items-center justify-center gap-0.5 {{ request()->routeIs('shop*') ? 'text-gold-600' : 'text-gray-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            <span class="text-[10px] font-medium">{{ __('shop.nav_categories') }}</span>
        </a>

        <a href="{{ route('cart') }}" class="flex flex-col items-center justify-center gap-0.5 relative {{ request()->routeIs('cart') ? 'text-gold-600' : 'text-gray-500' }}">
            <div class="relative">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                <livewire:cart-count-badge />
            </div>
            <span class="text-[10px] font-medium">{{ __('shop.cart') }}</span>
        </a>

        <a href="{{ auth()->check() ? route('account.profile') : route('login') }}" class="flex flex-col items-center justify-center gap-0.5 {{ request()->routeIs('account.*') ? 'text-gold-600' : 'text-gray-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span class="text-[10px] font-medium">{{ __('shop.account') }}</span>
        </a>
    </div>
</nav>
{{-- Spacer for mobile bottom nav --}}
<div class="lg:hidden h-16"></div>
