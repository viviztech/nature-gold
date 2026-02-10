<x-account-layout :title="__('shop.profile')">

    {{-- Session Messages --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 flex items-center gap-2">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Profile Information --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="font-heading text-xl font-bold text-gray-900 mb-6">{{ __('shop.profile_info') }}</h2>

        <form method="POST" action="{{ route('account.profile.update') }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.full_name') }}</label>
                    <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.email') }}</label>
                    <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.phone') }}</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                           placeholder="{{ __('shop.phone_placeholder') }}">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit"
                        class="px-6 py-2.5 bg-nature-700 text-white font-semibold rounded-lg hover:bg-nature-800 transition text-sm">
                    {{ __('shop.save_changes') }}
                </button>
            </div>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="font-heading text-xl font-bold text-gray-900 mb-6">{{ __('shop.change_password') }}</h2>

        <form method="POST" action="{{ route('account.password.update') }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Current Password --}}
                <div class="md:col-span-2">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.current_password') }}</label>
                    <input type="password" id="current_password" name="current_password" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                           placeholder="{{ __('shop.current_password_placeholder') }}">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- New Password --}}
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.new_password') }}</label>
                    <input type="password" id="new_password" name="password" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                           placeholder="{{ __('shop.new_password_placeholder') }}">
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm New Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.confirm_new_password') }}</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                           placeholder="{{ __('shop.confirm_password_placeholder') }}">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit"
                        class="px-6 py-2.5 bg-gold-500 text-white font-semibold rounded-lg hover:bg-gold-600 transition text-sm">
                    {{ __('shop.update_password') }}
                </button>
            </div>
        </form>
    </div>

</x-account-layout>
