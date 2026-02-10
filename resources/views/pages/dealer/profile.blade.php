<x-dealer-layout :title="__('dealer.profile')">

    {{-- Session Messages --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 flex items-center gap-2">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 flex items-center gap-2">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    @php
        $dealer = auth()->user()->dealer;
    @endphp

    {{-- Business Information --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="font-heading text-xl font-bold text-gray-900 mb-6">Business Information</h2>

        <form method="POST" action="{{ route('dealer.profile.update') }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Business Name --}}
                <div>
                    <label for="business_name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('dealer.business_name') }} *</label>
                    <input type="text" id="business_name" name="business_name"
                           value="{{ old('business_name', $dealer->business_name) }}" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none">
                    @error('business_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- GST Number --}}
                <div>
                    <label for="gst_number" class="block text-sm font-medium text-gray-700 mb-1">{{ __('dealer.gst_number') }}</label>
                    <input type="text" id="gst_number" name="gst_number"
                           value="{{ old('gst_number', $dealer->gst_number) }}"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none uppercase"
                           placeholder="e.g., 33AABCU9603R1ZM">
                    @error('gst_number')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Owner Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Owner Name *</label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', auth()->user()->name) }}" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                    <input type="tel" id="phone" name="phone"
                           value="{{ old('phone', auth()->user()->phone) }}" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                           placeholder="+91 98765 43210">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Territory (Read-only) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('dealer.territory') }}</label>
                    <div class="w-full border border-gray-100 bg-gray-50 rounded-lg px-4 py-2.5 text-sm text-gray-600">
                        {{ $dealer->territory?->label() ?? 'Not assigned' }}
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Territory cannot be changed. Contact support for changes.</p>
                </div>

                {{-- Status (Read-only) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Account Status</label>
                    <div class="w-full border border-gray-100 bg-gray-50 rounded-lg px-4 py-2.5 text-sm flex items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full {{ $dealer->status->color() }}">
                            {{ $dealer->status->label() }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Business Address --}}
            <div>
                <label for="business_address" class="block text-sm font-medium text-gray-700 mb-1">{{ __('dealer.business_address') }}</label>
                <textarea id="business_address" name="business_address" rows="3"
                          class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                          placeholder="Full business address including pincode">{{ old('business_address', $dealer->business_address) }}</textarea>
                @error('business_address')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit"
                        class="px-6 py-2.5 bg-nature-700 text-white font-semibold rounded-lg hover:bg-nature-800 transition text-sm">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    {{-- Account Information (Read-only) --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="font-heading text-xl font-bold text-gray-900 mb-6">Account Information</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Email (Read-only) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <div class="w-full border border-gray-100 bg-gray-50 rounded-lg px-4 py-2.5 text-sm text-gray-600">
                    {{ auth()->user()->email }}
                </div>
            </div>

            {{-- Member Since --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dealer Since</label>
                <div class="w-full border border-gray-100 bg-gray-50 rounded-lg px-4 py-2.5 text-sm text-gray-600">
                    {{ $dealer->created_at->format('d M Y') }}
                </div>
            </div>
        </div>
    </div>

</x-dealer-layout>
