<footer class="bg-nature-900 text-white">
    {{-- Newsletter Section --}}
    <div class="bg-gold-600">
        <div class="max-w-7xl mx-auto px-4 py-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-center md:text-left">
                <h3 class="font-heading text-xl font-bold text-white">{{ __('shop.newsletter_title') }}</h3>
                <p class="text-gold-100 text-sm mt-1">{{ __('shop.newsletter_subtitle') }}</p>
            </div>
            <livewire:newsletter-form />
        </div>
    </div>

    {{-- Main Footer --}}
    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        {{-- About --}}
        <div>
            <img src="{{ asset('images/logos/logo-white.png') }}"
                 srcset="{{ asset('images/logos/logo-white.png') }} 1x, {{ asset('images/logos/logo-white@2x.png') }} 2x"
                 alt="{{ config('app.name', 'Nature Gold') }}"
                 class="h-12 w-auto brightness-0 invert">
            <p class="text-gray-300 text-sm mt-3 leading-relaxed">
                {{ __('shop.footer_about') }}
            </p>
            <div class="flex gap-3 mt-4">
                @if($fb = \App\Models\Setting::get('facebook_url'))
                    <a href="{{ $fb }}" target="_blank" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-gold-500 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                    </a>
                @endif
                @if($ig = \App\Models\Setting::get('instagram_url'))
                    <a href="{{ $ig }}" target="_blank" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-gold-500 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                @endif
                @if($yt = \App\Models\Setting::get('youtube_url'))
                    <a href="{{ $yt }}" target="_blank" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-gold-500 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </a>
                @endif
            </div>
        </div>

        {{-- Quick Links --}}
        <div>
            <h4 class="font-heading font-semibold text-gold-400 mb-4">{{ __('shop.quick_links') }}</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('upcoming-products') }}" class="text-gray-300 hover:text-gold-400 transition">{{ __('shop.upcoming_products_title') }}</a></li>
                <li><a href="{{ route('page.show', 'privacy-policy') }}" class="text-gray-300 hover:text-gold-400 transition">{{ __('shop.privacy') }}</a></li>
                <li><a href="{{ route('page.show', 'terms-conditions') }}" class="text-gray-300 hover:text-gold-400 transition">{{ __('shop.terms') }}</a></li>
                <li><a href="{{ route('page.show', 'refund-policy') }}" class="text-gray-300 hover:text-gold-400 transition">{{ __('shop.refund_policy') }}</a></li>
                <li><a href="{{ route('page.show', 'shipping-policy') }}" class="text-gray-300 hover:text-gold-400 transition">{{ __('shop.shipping_policy') }}</a></li>
            </ul>
        </div>

        {{-- Contact Info --}}
        <div>
            <h4 class="font-heading font-semibold text-gold-400 mb-4">{{ __('shop.contact_us') }}</h4>
            <ul class="space-y-3 text-sm text-gray-300">
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 mt-0.5 shrink-0 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>{{ \App\Models\Setting::get('store_address', 'Tamil Nadu, India') }}</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <a href="tel:{{ \App\Models\Setting::get('store_phone') }}" class="hover:text-gold-400">{{ \App\Models\Setting::get('store_phone', '+91 98765 43210') }}</a>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <a href="mailto:{{ \App\Models\Setting::get('store_email') }}" class="hover:text-gold-400">{{ \App\Models\Setting::get('store_email', 'info@naturegold.in') }}</a>
                </li>
            </ul>
        </div>

        {{-- Payment & Trust --}}
        <div>
            <h4 class="font-heading font-semibold text-gold-400 mb-4">{{ __('shop.we_accept') }}</h4>
            <div class="flex flex-wrap gap-2 mb-4">
                <span class="px-3 py-1.5 bg-white/10 rounded text-xs font-medium">UPI</span>
                <span class="px-3 py-1.5 bg-white/10 rounded text-xs font-medium">Cards</span>
                <span class="px-3 py-1.5 bg-white/10 rounded text-xs font-medium">Netbanking</span>
                <span class="px-3 py-1.5 bg-white/10 rounded text-xs font-medium">Wallets</span>
                <span class="px-3 py-1.5 bg-white/10 rounded text-xs font-medium">COD</span>
            </div>
            <h4 class="font-heading font-semibold text-gold-400 mb-3 mt-6">{{ __('shop.dealer_zone') }}</h4>
            <a href="{{ route('dealer.register') }}" class="inline-block px-4 py-2 bg-gold-600 text-white text-sm rounded-lg font-medium hover:bg-gold-700 transition">
                {{ __('shop.become_dealer') }}
            </a>
        </div>
    </div>

    {{-- Copyright --}}
    <div class="border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 py-4 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} {{ config('app.name', 'Nature Gold') }}. {{ __('shop.all_rights') }}
        </div>
    </div>
</footer>
