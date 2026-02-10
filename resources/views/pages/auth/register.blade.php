<x-layouts.app :title="__('shop.register')">

    <div class="bg-cream min-h-screen flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">

            {{-- Logo / Brand --}}
            <div class="text-center mb-8">
                <a href="{{ url('/') }}" class="inline-block">
                    <h1 class="font-heading text-3xl font-bold text-nature-700">Nature <span class="text-gold-500">Gold</span></h1>
                </a>
                <p class="text-gray-500 text-sm mt-2">{{ __('shop.register_subtitle') }}</p>
            </div>

            {{-- Register Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <h2 class="font-heading text-xl font-bold text-gray-900 mb-6">{{ __('shop.create_account') }}</h2>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.full_name') }}</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                               placeholder="{{ __('shop.full_name_placeholder') }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.email') }}</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                               placeholder="{{ __('shop.email_placeholder') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.phone') }}</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                               placeholder="{{ __('shop.phone_placeholder') }}">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.password') }}</label>
                        <input type="password" id="password" name="password" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                               placeholder="{{ __('shop.password_create_placeholder') }}">
                        @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.confirm_password') }}</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                               placeholder="{{ __('shop.confirm_password_placeholder') }}">
                    </div>

                    {{-- Terms --}}
                    <div class="flex items-start">
                        <input type="checkbox" id="terms" name="terms" required
                               class="w-4 h-4 text-gold-500 border-gray-300 rounded focus:ring-gold-500 mt-0.5">
                        <label for="terms" class="ml-2 text-sm text-gray-600">
                            {{ __('shop.agree_to') }}
                            <a href="{{ route('page.show', 'terms-and-conditions') }}" class="text-gold-600 hover:text-gold-700 underline">{{ __('shop.terms') }}</a>
                            {{ __('shop.and') }}
                            <a href="{{ route('page.show', 'privacy-policy') }}" class="text-gold-600 hover:text-gold-700 underline">{{ __('shop.privacy_policy') }}</a>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full py-3 bg-nature-700 text-white font-heading font-bold rounded-xl hover:bg-nature-800 transition shadow-sm">
                        {{ __('shop.create_account') }}
                    </button>
                </form>

                {{-- Divider --}}
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-3 bg-white text-gray-400 uppercase">{{ __('shop.or') }}</span>
                    </div>
                </div>

                {{-- Login Link --}}
                <p class="text-center text-sm text-gray-600">
                    {{ __('shop.already_have_account') }}
                    <a href="{{ route('login') }}" class="font-semibold text-gold-600 hover:text-gold-700">{{ __('shop.login_now') }}</a>
                </p>
            </div>

            {{-- Back to Home --}}
            <p class="text-center mt-6">
                <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    {{ __('shop.back_to_home') }}
                </a>
            </p>
        </div>
    </div>

</x-layouts.app>
