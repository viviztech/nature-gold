<x-account-layout :title="__('shop.addresses')">

    {{-- Session Messages --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 flex items-center gap-2">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-heading text-xl font-bold text-gray-900">{{ __('shop.saved_addresses') }}</h2>
            <button onclick="document.getElementById('address-form').classList.toggle('hidden')"
                    class="inline-flex items-center gap-1 px-4 py-2 bg-gold-500 text-white font-semibold rounded-lg hover:bg-gold-600 transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                {{ __('shop.add_address') }}
            </button>
        </div>

        {{-- Add/Edit Address Form --}}
        <div id="address-form" class="hidden border-b border-gray-100 p-6 bg-cream">
            <h3 class="font-heading font-bold text-gray-900 mb-4">{{ __('shop.new_address') }}</h3>
            <form method="POST" action="{{ route('account.addresses.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.name') }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none bg-white">
                        @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.phone') }}</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none bg-white">
                        @error('phone') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.address_line1') }}</label>
                        <input type="text" name="line1" value="{{ old('line1') }}" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none bg-white">
                        @error('line1') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.address_line2') }}</label>
                        <input type="text" name="line2" value="{{ old('line2') }}"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none bg-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.city') }}</label>
                        <input type="text" name="city" value="{{ old('city') }}" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none bg-white">
                        @error('city') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.district') }}</label>
                        <select name="district" required
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none bg-white">
                            <option value="">{{ __('shop.select_district') }}</option>
                            @foreach(\App\Enums\TamilNaduDistrict::cases() as $dist)
                                <option value="{{ $dist->value }}" {{ old('district') === $dist->value ? 'selected' : '' }}>{{ $dist->label() }}</option>
                            @endforeach
                        </select>
                        @error('district') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.state') }}</label>
                        <input type="text" name="state" value="{{ old('state', 'Tamil Nadu') }}" readonly
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm bg-gray-50 text-gray-600 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.pincode') }}</label>
                        <input type="text" name="pincode" value="{{ old('pincode') }}" maxlength="6" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none bg-white">
                        @error('pincode') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2 flex items-center gap-2">
                        <input type="checkbox" name="is_default" id="is_default" value="1"
                               class="w-4 h-4 text-gold-500 border-gray-300 rounded focus:ring-gold-500">
                        <label for="is_default" class="text-sm text-gray-600">{{ __('shop.set_default') }}</label>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-6 py-2.5 bg-nature-700 text-white font-semibold rounded-lg hover:bg-nature-800 transition text-sm">
                        {{ __('shop.save_address') }}
                    </button>
                    <button type="button" onclick="document.getElementById('address-form').classList.add('hidden')"
                            class="px-6 py-2.5 bg-gray-100 text-gray-600 font-semibold rounded-lg hover:bg-gray-200 transition text-sm">
                        {{ __('shop.cancel') }}
                    </button>
                </div>
            </form>
        </div>

        @if($addresses->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($addresses as $address)
                    <div class="p-6 flex flex-col md:flex-row md:items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <p class="font-semibold text-gray-800">{{ $address->name }}</p>
                                @if($address->is_default)
                                    <span class="px-2 py-0.5 bg-gold-100 text-gold-700 text-xs font-semibold rounded">{{ __('shop.default') }}</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600">{{ $address->phone }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $address->full_address }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('account.addresses.destroy', $address) }}"
                                  onsubmit="return confirm('{{ __('shop.delete_address_confirm') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 px-6">
                <div class="w-20 h-20 mx-auto mb-4 bg-gold-50 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h3 class="font-heading text-lg font-bold text-gray-800 mb-2">{{ __('shop.no_addresses') }}</h3>
                <p class="text-gray-500 text-sm">{{ __('shop.no_addresses_message') }}</p>
            </div>
        @endif
    </div>

</x-account-layout>
