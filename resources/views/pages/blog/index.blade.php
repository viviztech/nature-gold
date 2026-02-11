<x-layouts.app
    :title="__('shop.blog_title')"
    :metaDescription="__('shop.blog_subtitle')"
    :jsonLd="[
        '@context' => 'https://schema.org',
        '@type' => 'Blog',
        'name' => __('shop.blog_title'),
        'description' => __('shop.blog_subtitle'),
        'url' => route('blog.index'),
    ]"
>

    <div class="bg-cream min-h-screen">
        <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">

            {{-- Page Header --}}
            <div class="text-center mb-10">
                <h1 class="font-heading text-3xl md:text-4xl font-bold text-gray-900">{{ __('shop.blog_title') }}</h1>
                <div class="mt-3 w-16 h-1 bg-gold-500 rounded mx-auto"></div>
                <p class="mt-4 text-gray-500 max-w-2xl mx-auto">{{ __('shop.blog_subtitle') }}</p>
            </div>

            {{-- Category Filter --}}
            @if($categories->isNotEmpty())
                <div class="flex flex-wrap items-center justify-center gap-2 mb-8">
                    <a href="{{ route('blog.index') }}"
                       class="px-4 py-2 rounded-full text-sm font-medium transition {{ !request('category') ? 'bg-gold-500 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-gold-300' }}">
                        All
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('blog.index', ['category' => $cat]) }}"
                           class="px-4 py-2 rounded-full text-sm font-medium transition {{ request('category') === $cat ? 'bg-gold-500 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-gold-300' }}">
                            {{ ucfirst($cat) }}
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- Blog Posts Grid --}}
            @if($posts->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    @foreach($posts as $post)
                        <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition">
                            {{-- Featured Image --}}
                            <a href="{{ route('blog.show', $post->slug) }}" class="block aspect-[16/10] overflow-hidden">
                                @if($post->featured_image)
                                    <img src="{{ Storage::url($post->featured_image) }}"
                                         alt="{{ $post->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                         loading="lazy">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gold-100 to-nature-100 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                    </div>
                                @endif
                            </a>

                            {{-- Content --}}
                            <div class="p-5">
                                {{-- Category & Date --}}
                                <div class="flex items-center gap-3 text-xs text-gray-400 mb-3">
                                    @if($post->category)
                                        <span class="bg-gold-50 text-gold-700 px-2 py-0.5 rounded-full font-medium">{{ ucfirst($post->category) }}</span>
                                    @endif
                                    <span>{{ $post->published_at->format('M d, Y') }}</span>
                                    <span>{{ __('shop.min_read', ['min' => $post->reading_time]) }}</span>
                                </div>

                                <h2 class="font-heading font-bold text-lg text-gray-900 mb-2 line-clamp-2 group-hover:text-gold-600 transition">
                                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                </h2>

                                @if($post->excerpt)
                                    <p class="text-sm text-gray-500 line-clamp-3 mb-4">{{ $post->excerpt }}</p>
                                @endif

                                <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-gold-600 hover:text-gold-700 transition">
                                    {{ __('shop.read_more') }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-10">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    <p class="text-gray-500">{{ __('shop.no_posts') }}</p>
                </div>
            @endif

        </div>
    </div>

</x-layouts.app>
