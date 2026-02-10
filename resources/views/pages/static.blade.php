<x-layouts.app :title="$page->title">

    {{-- Page Header --}}
    <section class="bg-cream border-b border-gray-100">
        <div class="max-w-4xl mx-auto px-4 py-12 md:py-16 text-center">
            <h1 class="font-heading text-3xl md:text-4xl font-bold text-gray-900">{{ $page->title }}</h1>
            <div class="mt-3 w-16 h-1 bg-gold-500 mx-auto rounded"></div>
        </div>
    </section>

    {{-- Page Content --}}
    <section class="max-w-4xl mx-auto px-4 py-12 md:py-16">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-10">
            <div class="prose prose-lg max-w-none
                        prose-headings:font-heading prose-headings:text-gray-900
                        prose-h2:text-2xl prose-h2:mt-8 prose-h2:mb-4
                        prose-h3:text-xl prose-h3:mt-6 prose-h3:mb-3
                        prose-p:text-gray-600 prose-p:leading-relaxed
                        prose-a:text-gold-600 prose-a:no-underline hover:prose-a:underline
                        prose-strong:text-gray-800
                        prose-ul:text-gray-600 prose-ol:text-gray-600
                        prose-li:marker:text-gold-500">
                {!! $page->content !!}
            </div>
        </div>

        {{-- Last Updated --}}
        @if($page->updated_at)
            <p class="text-center text-sm text-gray-400 mt-6">
                {{ __('shop.last_updated') }}: {{ $page->updated_at->format('d M Y') }}
            </p>
        @endif
    </section>

</x-layouts.app>
