<x-layouts.app :title="__('shop.about_us')">

    {{-- Hero Banner --}}
    <section class="relative bg-gradient-to-br from-nature-800 to-nature-900 py-20 md:py-28">
        <div class="absolute inset-0 opacity-10">
            <div class="w-full h-full" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 80 80%22><circle cx=%2240%22 cy=%2240%22 r=%222%22 fill=%22%23fff%22/></svg>'); background-size: 40px 40px;"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 text-center">
            <h1 class="font-heading text-4xl md:text-5xl font-bold text-white">{{ __('shop.about_us') }}</h1>
            <div class="mt-3 w-16 h-1 bg-gold-500 mx-auto rounded"></div>
            <p class="mt-6 text-nature-200 text-lg max-w-2xl mx-auto">{{ __('shop.about_subtitle') }}</p>
        </div>
    </section>

    {{-- Dynamic Page Content --}}
    @if(isset($page) && $page->content)
        <section class="max-w-4xl mx-auto px-4 py-16">
            <div class="prose prose-lg max-w-none prose-headings:font-heading prose-headings:text-gray-900 prose-a:text-gold-600">
                {!! $page->content !!}
            </div>
        </section>
    @else
        {{-- Brand Story --}}
        <section class="max-w-7xl mx-auto px-4 py-16 md:py-20">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="text-gold-500 font-semibold text-sm uppercase tracking-wider">{{ __('shop.our_story') }}</span>
                    <h2 class="font-heading text-3xl md:text-4xl font-bold text-gray-900 mt-2">{{ __('shop.about_story_title') }}</h2>
                    <div class="mt-2 w-16 h-1 bg-gold-500 rounded"></div>
                    <p class="mt-6 text-gray-600 leading-relaxed">{{ __('shop.about_story_p1') }}</p>
                    <p class="mt-4 text-gray-600 leading-relaxed">{{ __('shop.about_story_p2') }}</p>
                </div>
                <div class="bg-cream rounded-2xl aspect-square flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-24 h-24 text-gold-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-gray-400 mt-2 text-sm">{{ __('shop.brand_image_placeholder') }}</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Manufacturing Process --}}
        <section class="bg-cream py-16 md:py-20">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <span class="text-gold-500 font-semibold text-sm uppercase tracking-wider">{{ __('shop.our_process') }}</span>
                    <h2 class="font-heading text-3xl md:text-4xl font-bold text-gray-900 mt-2">{{ __('shop.manufacturing_title') }}</h2>
                    <div class="mt-2 w-16 h-1 bg-gold-500 mx-auto rounded"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    {{-- Step 1 --}}
                    <div class="relative bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
                        <div class="w-12 h-12 bg-gold-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-heading font-bold text-lg">1</div>
                        <h3 class="font-heading font-bold text-gray-900 mb-2">{{ __('shop.process_step1_title') }}</h3>
                        <p class="text-sm text-gray-500">{{ __('shop.process_step1_desc') }}</p>
                    </div>

                    {{-- Step 2 --}}
                    <div class="relative bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
                        <div class="w-12 h-12 bg-gold-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-heading font-bold text-lg">2</div>
                        <h3 class="font-heading font-bold text-gray-900 mb-2">{{ __('shop.process_step2_title') }}</h3>
                        <p class="text-sm text-gray-500">{{ __('shop.process_step2_desc') }}</p>
                    </div>

                    {{-- Step 3 --}}
                    <div class="relative bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
                        <div class="w-12 h-12 bg-gold-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-heading font-bold text-lg">3</div>
                        <h3 class="font-heading font-bold text-gray-900 mb-2">{{ __('shop.process_step3_title') }}</h3>
                        <p class="text-sm text-gray-500">{{ __('shop.process_step3_desc') }}</p>
                    </div>

                    {{-- Step 4 --}}
                    <div class="relative bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
                        <div class="w-12 h-12 bg-gold-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-heading font-bold text-lg">4</div>
                        <h3 class="font-heading font-bold text-gray-900 mb-2">{{ __('shop.process_step4_title') }}</h3>
                        <p class="text-sm text-gray-500">{{ __('shop.process_step4_desc') }}</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Certifications --}}
        <section class="max-w-7xl mx-auto px-4 py-16 md:py-20">
            <div class="text-center mb-12">
                <span class="text-gold-500 font-semibold text-sm uppercase tracking-wider">{{ __('shop.quality_assurance') }}</span>
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-gray-900 mt-2">{{ __('shop.certifications_title') }}</h2>
                <div class="mt-2 w-16 h-1 bg-gold-500 mx-auto rounded"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
                    <div class="w-16 h-16 mx-auto bg-nature-50 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-8 h-8 text-nature-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="font-heading font-bold text-gray-900 text-sm">{{ __('shop.cert_fssai') }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ __('shop.cert_fssai_desc') }}</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
                    <div class="w-16 h-16 mx-auto bg-gold-50 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-8 h-8 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-heading font-bold text-gray-900 text-sm">{{ __('shop.cert_organic') }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ __('shop.cert_organic_desc') }}</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
                    <div class="w-16 h-16 mx-auto bg-nature-50 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-8 h-8 text-nature-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                    <h3 class="font-heading font-bold text-gray-900 text-sm">{{ __('shop.cert_lab') }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ __('shop.cert_lab_desc') }}</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
                    <div class="w-16 h-16 mx-auto bg-gold-50 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-8 h-8 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-heading font-bold text-gray-900 text-sm">{{ __('shop.cert_eco') }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ __('shop.cert_eco_desc') }}</p>
                </div>
            </div>
        </section>
    @endif

</x-layouts.app>
