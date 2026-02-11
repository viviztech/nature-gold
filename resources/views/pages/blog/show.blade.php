<x-layouts.app
    :title="$post->meta_title ?: $post->title"
    :metaDescription="$post->meta_description ?: $post->excerpt"
    ogType="article"
    :ogImage="$post->featured_image ? Storage::url($post->featured_image) : null"
    :jsonLd="[
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        'headline' => $post->title,
        'description' => $post->excerpt ?? '',
        'image' => $post->featured_image ? Storage::url($post->featured_image) : '',
        'author' => [
            '@type' => 'Person',
            'name' => $post->author?->name ?? 'Nature Gold',
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Nature Gold',
        ],
        'datePublished' => $post->published_at->toIso8601String(),
        'dateModified' => $post->updated_at->toIso8601String(),
        'mainEntityOfPage' => route('blog.show', $post->slug),
    ]"
>

    <div class="bg-cream min-h-screen">
        <div class="max-w-4xl mx-auto px-4 py-8 md:py-12">

            {{-- Back to Blog --}}
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1 text-sm text-gold-600 hover:text-gold-700 mb-6 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                {{ __('shop.back_to_blog') }}
            </a>

            {{-- Article Header --}}
            <article>
                <header class="mb-8">
                    {{-- Category & Meta --}}
                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-400 mb-4">
                        @if($post->category)
                            <span class="bg-gold-50 text-gold-700 px-3 py-1 rounded-full font-medium text-xs">{{ ucfirst($post->category) }}</span>
                        @endif
                        <span>{{ $post->published_at->format('F d, Y') }}</span>
                        <span>{{ __('shop.min_read', ['min' => $post->reading_time]) }}</span>
                        @if($post->author)
                            <span>{{ __('shop.by_author', ['author' => $post->author->name]) }}</span>
                        @endif
                    </div>

                    <h1 class="font-heading text-3xl md:text-4xl font-bold text-gray-900 leading-tight">{{ $post->title }}</h1>

                    @if($post->excerpt)
                        <p class="mt-4 text-lg text-gray-500 leading-relaxed">{{ $post->excerpt }}</p>
                    @endif
                </header>

                {{-- Featured Image --}}
                @if($post->featured_image)
                    <div class="rounded-xl overflow-hidden mb-8 aspect-[16/9]">
                        <img src="{{ Storage::url($post->featured_image) }}"
                             alt="{{ $post->title }}"
                             class="w-full h-full object-cover">
                    </div>
                @endif

                {{-- Article Content --}}
                <div class="prose prose-lg max-w-none prose-headings:font-heading prose-headings:text-gray-900 prose-a:text-gold-600 prose-a:no-underline hover:prose-a:underline prose-img:rounded-lg">
                    {!! $post->content !!}
                </div>

                {{-- Tags --}}
                @if($post->tags && count($post->tags) > 0)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-500 mb-3">{{ __('shop.tags') }}</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('blog.index', ['tag' => $tag]) }}"
                                   class="px-3 py-1 bg-white border border-gray-200 rounded-full text-sm text-gray-600 hover:border-gold-300 hover:text-gold-600 transition">
                                    {{ $tag }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Share Buttons --}}
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-500 mb-3">{{ __('shop.share') }}</h3>
                    <div class="flex items-center gap-3">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' - ' . route('blog.show', $post->slug)) }}"
                           target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-600 transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            WhatsApp
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}"
                           target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                            Facebook
                        </a>
                    </div>
                </div>
            </article>

            {{-- Related Posts --}}
            @if($relatedPosts->isNotEmpty())
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <h2 class="font-heading text-2xl font-bold text-gray-900 mb-6">{{ __('shop.related_products') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedPosts as $related)
                            <a href="{{ route('blog.show', $related->slug) }}" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition">
                                <div class="aspect-[16/10] overflow-hidden">
                                    @if($related->featured_image)
                                        <img src="{{ Storage::url($related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" loading="lazy">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gold-100 to-nature-100"></div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <p class="text-xs text-gray-400 mb-1">{{ $related->published_at->format('M d, Y') }}</p>
                                    <h3 class="font-heading font-semibold text-gray-900 line-clamp-2 group-hover:text-gold-600 transition">{{ $related->title }}</h3>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

</x-layouts.app>
