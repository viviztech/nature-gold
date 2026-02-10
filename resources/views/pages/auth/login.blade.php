<x-layouts.app :title="__('shop.login')">

    <div class="bg-cream min-h-screen flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">

            {{-- Logo / Brand --}}
            <div class="text-center mb-8">
                <a href="{{ url('/') }}" class="inline-block">
                    <h1 class="font-heading text-3xl font-bold text-nature-700">Nature <span class="text-gold-500">Gold</span></h1>
                </a>
                <p class="text-gray-500 text-sm mt-2">{{ __('shop.login_subtitle') }}</p>
            </div>

            {{-- Login Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <h2 class="font-heading text-xl font-bold text-gray-900 mb-6">{{ __('shop.login') }}</h2>

                {{-- Session Messages --}}
                @if(session('status'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email or Phone --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.email_or_phone') }}</label>
                        <input type="text" id="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                               placeholder="{{ __('shop.email_or_phone_placeholder') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('shop.password') }}</label>
                            <a href="{{ route('password.request') }}" class="text-xs text-gold-600 hover:text-gold-700">{{ __('shop.forgot_password') }}</a>
                        </div>
                        <input type="password" id="password" name="password" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                               placeholder="{{ __('shop.password_placeholder') }}">
                        @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                               class="w-4 h-4 text-gold-500 border-gray-300 rounded focus:ring-gold-500"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="ml-2 text-sm text-gray-600">{{ __('shop.remember_me') }}</label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full py-3 bg-nature-700 text-white font-heading font-bold rounded-xl hover:bg-nature-800 transition shadow-sm">
                        {{ __('shop.login') }}
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

                {{-- Register Link --}}
                <p class="text-center text-sm text-gray-600">
                    {{ __('shop.no_account') }}
                    <a href="{{ route('register') }}" class="font-semibold text-gold-600 hover:text-gold-700">{{ __('shop.register_now') }}</a>
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
