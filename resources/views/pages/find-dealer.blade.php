<x-layouts.app :title="__('shop.find_dealer')">

    <div class="max-w-7xl mx-auto px-4 py-8">
        {{-- Header --}}
        <div class="text-center mb-10">
            <h1 class="font-heading text-3xl md:text-4xl font-bold text-gray-900">{{ __('shop.find_dealer') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('shop.find_dealer_subtitle') }}</p>
        </div>

        {{-- Filter --}}
        <div class="flex justify-center mb-8">
            <form method="GET" action="{{ route('find-dealer') }}" class="w-full max-w-md">
                <select name="district"
                        onchange="this.form.submit()"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none bg-white">
                    <option value="">{{ __('shop.all_districts') }}</option>
                    @foreach($districts as $dist)
                        <option value="{{ $dist->value }}" {{ $district === $dist->value ? 'selected' : '' }}>
                            {{ $dist->label() }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Dealer List --}}
        @if($grouped->count() > 0)
            <div class="space-y-8">
                @foreach($grouped as $territory => $territoryDealers)
                    <div>
                        <h2 class="font-heading text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $territory }}
                            <span class="text-sm font-normal text-gray-400">({{ trans_choice('shop.dealer_count', $territoryDealers->count()) }})</span>
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($territoryDealers as $dealer)
                                <div class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gold-50 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $dealer->business_name }}</h3>
                                            <span class="inline-flex mt-1 px-2 py-0.5 text-xs font-medium rounded-full
                                                {{ $dealer->business_type === 'wholesale' ? 'bg-blue-50 text-blue-700' : ($dealer->business_type === 'distributor' ? 'bg-purple-50 text-purple-700' : 'bg-gray-100 text-gray-600') }}">
                                                {{ ucfirst($dealer->business_type) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto mb-4 bg-gold-50 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <p class="text-gray-500">{{ __('shop.no_dealers_found') }}</p>
            </div>
        @endif

        {{-- Become a Dealer CTA --}}
        <div class="mt-12 bg-gradient-to-r from-gold-50 to-nature-50 rounded-2xl p-8 text-center">
            <h3 class="font-heading text-xl font-bold text-gray-900">{{ __('shop.become_dealer_cta') }}</h3>
            <a href="{{ route('dealer.register') }}"
               class="inline-flex items-center gap-2 mt-4 px-6 py-3 bg-nature-700 text-white font-semibold rounded-xl hover:bg-nature-800 transition">
                {{ __('shop.become_dealer') }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

</x-layouts.app>
