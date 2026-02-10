<x-layouts.app :title="__('shop.contact_us')">

    {{-- Hero Banner --}}
    <section class="relative bg-gradient-to-br from-nature-800 to-nature-900 py-16 md:py-20">
        <div class="relative max-w-7xl mx-auto px-4 text-center">
            <h1 class="font-heading text-4xl md:text-5xl font-bold text-white">{{ __('shop.contact_us') }}</h1>
            <div class="mt-3 w-16 h-1 bg-gold-500 mx-auto rounded"></div>
            <p class="mt-4 text-nature-200 text-lg max-w-xl mx-auto">{{ __('shop.contact_subtitle') }}</p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 py-12 md:py-16">
        {{-- Session Messages --}}
        @if(session('success'))
            <div class="mb-8 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 flex items-center gap-2 max-w-3xl mx-auto">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Contact Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h2 class="font-heading text-xl font-bold text-gray-900 mb-6">{{ __('shop.send_message') }}</h2>

                    <form method="POST" action="{{ route('contact.submit') }}" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Name --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.name') }} <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                                       placeholder="{{ __('shop.name_placeholder') }}">
                                @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.email') }} <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                                       placeholder="{{ __('shop.email_placeholder') }}">
                                @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.phone') }}</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                                       placeholder="{{ __('shop.phone_placeholder') }}">
                                @error('phone') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Subject --}}
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.subject') }} <span class="text-red-500">*</span></label>
                                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none"
                                       placeholder="{{ __('shop.subject_placeholder') }}">
                                @error('subject') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Message --}}
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.message') }} <span class="text-red-500">*</span></label>
                            <textarea id="message" name="message" rows="5" required
                                      class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none resize-none"
                                      placeholder="{{ __('shop.message_placeholder') }}">{{ old('message') }}</textarea>
                            @error('message') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit"
                                class="px-8 py-3 bg-nature-700 text-white font-heading font-bold rounded-xl hover:bg-nature-800 transition shadow-sm">
                            {{ __('shop.send_message') }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- Contact Info Sidebar --}}
            <div class="space-y-6">
                {{-- Store Info --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-heading font-bold text-gray-900 mb-4">{{ __('shop.store_info') }}</h3>

                    <div class="space-y-4">
                        {{-- Address --}}
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gold-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ __('shop.address') }}</p>
                                <p class="text-sm text-gray-500 mt-0.5">{{ __('shop.store_address') }}</p>
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-nature-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-nature-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ __('shop.phone') }}</p>
                                <p class="text-sm text-gray-500 mt-0.5">{{ __('shop.store_phone') }}</p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gold-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ __('shop.email') }}</p>
                                <p class="text-sm text-gray-500 mt-0.5">{{ __('shop.store_email') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- WhatsApp --}}
                <a href="https://wa.me/{{ __('shop.whatsapp_number') }}" target="_blank"
                   class="block bg-green-500 rounded-xl p-6 text-white hover:bg-green-600 transition shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </div>
                        <div>
                            <p class="font-heading font-bold text-lg">{{ __('shop.chat_whatsapp') }}</p>
                            <p class="text-green-100 text-sm">{{ __('shop.whatsapp_subtitle') }}</p>
                        </div>
                    </div>
                </a>

                {{-- Map Placeholder --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="aspect-[4/3] bg-cream flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            <p class="text-gray-400 mt-2 text-sm">{{ __('shop.map_placeholder') }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-layouts.app>
