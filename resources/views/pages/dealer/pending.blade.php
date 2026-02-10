<x-layouts.app :title="__('dealer.pending_title')">

    <div class="bg-cream min-h-screen">
        <div class="max-w-2xl mx-auto px-4 py-16 md:py-24">

            {{-- Status Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Header Banner --}}
                @if($dealer->status->value === 'rejected')
                    <div class="bg-gradient-to-r from-red-500 to-red-600 px-8 py-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <h1 class="font-heading text-2xl font-bold text-white">{{ __('dealer.rejected_title') }}</h1>
                    </div>
                @else
                    <div class="bg-gradient-to-r from-gold-500 to-gold-600 px-8 py-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h1 class="font-heading text-2xl font-bold text-white">{{ __('dealer.pending_title') }}</h1>
                    </div>
                @endif

                {{-- Content --}}
                <div class="p-8 text-center">

                    @if($dealer->status->value === 'rejected')
                        <p class="text-gray-600 font-body leading-relaxed mb-6">
                            {{ __('dealer.rejected_message') }}
                        </p>

                        {{-- Rejection Reason --}}
                        @if($dealer->rejection_reason)
                            <div class="bg-red-50 border border-red-200 rounded-xl p-5 text-left mb-6">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-semibold text-red-800 mb-1">Reason for Rejection</p>
                                        <p class="text-sm text-red-700">{{ $dealer->rejection_reason }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="mb-6">
                            {{-- Animated dots indicator --}}
                            <div class="flex items-center justify-center gap-2 mb-6">
                                <span class="w-3 h-3 bg-gold-400 rounded-full animate-bounce" style="animation-delay: 0ms;"></span>
                                <span class="w-3 h-3 bg-gold-500 rounded-full animate-bounce" style="animation-delay: 150ms;"></span>
                                <span class="w-3 h-3 bg-gold-600 rounded-full animate-bounce" style="animation-delay: 300ms;"></span>
                            </div>

                            <p class="text-gray-600 font-body leading-relaxed">
                                {{ __('dealer.pending_message') }}
                            </p>
                        </div>
                    @endif

                    {{-- Application Details --}}
                    <div class="bg-gray-50 rounded-xl p-5 text-left">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Application Details</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">{{ __('dealer.business_name') }}</span>
                                <span class="font-medium text-gray-800">{{ $dealer->business_name }}</span>
                            </div>
                            @if($dealer->gst_number)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">{{ __('dealer.gst_number') }}</span>
                                    <span class="font-mono font-medium text-gray-800">{{ $dealer->gst_number }}</span>
                                </div>
                            @endif
                            @if($dealer->territory)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">{{ __('dealer.territory') }}</span>
                                    <span class="font-medium text-gray-800">{{ $dealer->territory->label() }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-500">Status</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full {{ $dealer->status->value === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $dealer->status->label() }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Applied On</span>
                                <span class="font-medium text-gray-800">{{ $dealer->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="{{ route('home') }}"
                           class="inline-flex items-center gap-2 px-6 py-2.5 bg-nature-700 text-white font-semibold rounded-lg hover:bg-nature-800 transition text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Back to Home
                        </a>
                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center gap-2 px-6 py-2.5 bg-white text-gray-700 font-semibold rounded-lg border border-gray-200 hover:border-gold-300 hover:text-gold-700 transition text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Contact Support
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

</x-layouts.app>
