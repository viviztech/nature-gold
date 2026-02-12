<x-account-layout :title="__('shop.referrals')">

    <div class="space-y-6">

        {{-- Referral Code Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="font-heading text-xl font-bold text-gray-900">{{ __('shop.your_referral_code') }}</h2>
            </div>
            <div class="p-4 sm:p-6">
                <p class="text-sm text-gray-600 mb-4">{{ __('shop.referral_description') }}</p>

                <div class="flex flex-col gap-4">
                    {{-- Code Display --}}
                    <div class="flex items-center gap-3 bg-gold-50 border-2 border-dashed border-gold-300 rounded-xl px-4 sm:px-6 py-3 sm:py-4 w-fit">
                        <span class="font-heading text-lg sm:text-2xl font-bold text-gold-700 tracking-wider sm:tracking-widest" id="referral-code">{{ $user->referral_code }}</span>
                        <button onclick="copyCode()" class="p-2 text-gold-600 hover:text-gold-800 hover:bg-gold-100 rounded-lg transition flex-shrink-0" title="{{ __('shop.copy') }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </button>
                    </div>

                    {{-- Share Buttons --}}
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="https://wa.me/?text={{ urlencode(__('shop.referral_whatsapp_message', ['url' => route('referral.link', $user->referral_code)])) }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            {{ __('shop.share_whatsapp') }}
                        </a>
                        <button onclick="copyLink()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            {{ __('shop.copy_link') }}
                        </button>
                    </div>
                </div>

                <p class="mt-4 text-xs text-gray-500" id="copy-feedback"></p>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <div class="w-12 h-12 mx-auto mb-3 bg-nature-50 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-nature-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="font-heading text-3xl font-bold text-gray-900">{{ $totalCount }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ __('shop.total_referrals') }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <div class="w-12 h-12 mx-auto mb-3 bg-gold-50 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="font-heading text-3xl font-bold text-gray-900">₹{{ number_format($totalRewards, 0) }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ __('shop.total_rewards') }}</p>
            </div>
        </div>

        {{-- Referral List --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="font-heading text-xl font-bold text-gray-900">{{ __('shop.your_referrals') }}</h2>
            </div>

            @if($referrals->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($referrals as $referral)
                        <div class="p-4 sm:p-6 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 bg-nature-50 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-sm font-bold text-nature-700">{{ strtoupper(substr($referral->referred->name, 0, 1)) }}</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-800 text-sm truncate">{{ $referral->referred->name }}</p>
                                    <p class="text-xs text-gray-500">{{ __('shop.joined') }} {{ $referral->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                @if($referral->is_rewarded)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded-lg">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        ₹{{ number_format($referral->reward_amount, 0) }} {{ __('shop.earned') }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-yellow-50 text-yellow-700 text-xs font-semibold rounded-lg">{{ __('shop.pending') }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 px-6">
                    <div class="w-20 h-20 mx-auto mb-4 bg-gold-50 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                    <h3 class="font-heading text-lg font-bold text-gray-800 mb-2">{{ __('shop.no_referrals_yet') }}</h3>
                    <p class="text-gray-500 text-sm">{{ __('shop.no_referrals_message') }}</p>
                </div>
            @endif
        </div>

    </div>

    @push('scripts')
    <script>
        function copyCode() {
            navigator.clipboard.writeText(document.getElementById('referral-code').textContent.trim());
            document.getElementById('copy-feedback').textContent = '{{ __("shop.code_copied") }}';
            setTimeout(() => document.getElementById('copy-feedback').textContent = '', 3000);
        }

        function copyLink() {
            navigator.clipboard.writeText('{{ route("referral.link", $user->referral_code) }}');
            document.getElementById('copy-feedback').textContent = '{{ __("shop.link_copied") }}';
            setTimeout(() => document.getElementById('copy-feedback').textContent = '', 3000);
        }
    </script>
    @endpush

</x-account-layout>
