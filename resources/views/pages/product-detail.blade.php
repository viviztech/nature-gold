<x-layouts.app :title="$product->name">

    <div class="max-w-7xl mx-auto px-4 py-8">
        {{-- Breadcrumb --}}
        <nav class="text-sm text-gray-500 mb-6 overflow-x-auto whitespace-nowrap pb-1 -mb-1">
            <a href="{{ route('home') }}" class="hover:text-gold-600">{{ __('shop.nav_home') }}</a>
            <span class="mx-1.5 sm:mx-2">/</span>
            <a href="{{ route('shop') }}" class="hover:text-gold-600">{{ __('shop.nav_shop') }}</a>
            @if($product->category)
                <span class="mx-1.5 sm:mx-2">/</span>
                <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="hover:text-gold-600">{{ $product->category->name }}</a>
            @endif
            <span class="mx-1.5 sm:mx-2">/</span>
            <span class="text-gray-800">{{ $product->name }}</span>
        </nav>

        <div class="lg:flex gap-10">
            {{-- Image Gallery --}}
            <div class="lg:w-1/2" x-data="{ activeImage: 0 }">
                <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 mb-4">
                    @if($product->images->count() > 0)
                        @foreach($product->images as $index => $image)
                            <img x-show="activeImage === {{ $index }}"
                                 x-transition
                                 src="{{ Storage::url($image->image_path) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover">
                        @endforeach
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </div>
                @if($product->images->count() > 1)
                    <div class="flex gap-2 overflow-x-auto pb-2">
                        @foreach($product->images as $index => $image)
                            <button @click="activeImage = {{ $index }}"
                                    :class="activeImage === {{ $index }} ? 'ring-2 ring-gold-500' : 'ring-1 ring-gray-200'"
                                    class="w-20 h-20 rounded-lg overflow-hidden shrink-0">
                                <img src="{{ Storage::url($image->image_path) }}" alt="" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Product Info --}}
            <div class="lg:w-1/2 mt-6 lg:mt-0">
                @if($product->category)
                    <p class="text-sm text-gold-600 font-medium uppercase tracking-wide">{{ $product->category->name }}</p>
                @endif

                <h1 class="font-heading text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ $product->name }}</h1>

                {{-- Rating --}}
                @if($product->reviews_avg_rating)
                    <div class="flex items-center gap-2 mt-2">
                        <div class="flex text-gold-500">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($product->reviews_avg_rating))
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                @else
                                    <svg class="w-4 h-4 fill-current text-gray-300" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm text-gray-500">({{ $product->reviews->count() }} {{ __('shop.reviews') }})</span>
                    </div>
                @endif

                {{-- Price --}}
                <div class="mt-4 flex items-baseline gap-3">
                    <span class="text-3xl font-bold text-nature-700">₹{{ number_format($product->effective_price, 0) }}</span>
                    @if($product->sale_price && $product->sale_price < $product->price)
                        <span class="text-lg text-gray-400 line-through">₹{{ number_format($product->price, 0) }}</span>
                        <span class="px-2 py-0.5 bg-red-100 text-red-600 text-sm font-bold rounded">-{{ $product->discount_percentage }}%</span>
                    @endif
                </div>

                {{-- Stock --}}
                <p class="mt-2 text-sm {{ $product->is_in_stock ? 'text-nature-600' : 'text-red-500' }}">
                    {{ $product->is_in_stock ? __('shop.in_stock') : __('shop.out_of_stock') }}
                </p>

                {{-- Variant Selector & Add to Cart --}}
                <div class="mt-6" x-data="{ selectedVariant: {{ $product->variants->first()?->id ?? 'null' }} }">
                    @if($product->variants->count() > 0)
                        <p class="text-sm font-medium text-gray-700 mb-2">{{ __('shop.quantity') }} / Size</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($product->variants as $variant)
                                <button @click="selectedVariant = {{ $variant->id }}"
                                        :class="selectedVariant === {{ $variant->id }} ? 'border-gold-500 bg-gold-50 text-gold-700' : 'border-gray-200 text-gray-600 hover:border-gold-300'"
                                        class="px-4 py-2 border-2 rounded-lg text-sm font-medium transition">
                                    {{ $variant->name }}
                                    <span class="text-xs block">₹{{ number_format($variant->effective_price, 0) }}</span>
                                </button>
                            @endforeach
                        </div>
                    @endif

                    @if($product->is_in_stock)
                        <livewire:add-to-cart-button :product="$product" />
                    @else
                        <livewire:stock-alert-button :productId="$product->id" :wire:key="'stock-alert-'.$product->id" />
                    @endif
                </div>

                {{-- Wishlist & Share --}}
                <div class="mt-6 pt-6 border-t border-gray-100 flex items-center gap-4">
                    <livewire:wishlist-button :productId="$product->id" size="lg" :wire:key="'wish-detail-'.$product->id" />
                    <a href="https://wa.me/?text={{ urlencode($product->name . ' - ₹' . $product->effective_price . ' ' . url()->current()) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 text-sm text-green-600 hover:text-green-700 font-medium">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        {{ __('shop.share_whatsapp') }}
                    </a>
                </div>

                {{-- Description Tabs --}}
                <div class="mt-6" x-data="{ tab: 'description' }">
                    <div class="flex border-b border-gray-200">
                        <button @click="tab = 'description'" :class="tab === 'description' ? 'border-gold-500 text-gold-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="px-4 py-3 text-sm font-medium border-b-2 transition">
                            {{ __('shop.description') }}
                        </button>
                        <button @click="tab = 'reviews'" :class="tab === 'reviews' ? 'border-gold-500 text-gold-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="px-4 py-3 text-sm font-medium border-b-2 transition">
                            {{ __('shop.reviews') }} ({{ $product->reviews->count() }})
                        </button>
                    </div>
                    <div class="py-4">
                        <div x-show="tab === 'description'" class="prose prose-sm max-w-none text-gray-600">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                        <div x-show="tab === 'reviews'">
                            @forelse($product->reviews->where('is_approved', true) as $review)
                                <div class="py-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                    <div class="flex items-center gap-2">
                                        <div class="flex text-gold-500">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300 fill-current' }}" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                            @endfor
                                        </div>
                                        <span class="text-sm font-medium text-gray-800">{{ $review->user?->name ?? 'Customer' }}</span>
                                        <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if($review->comment)
                                        <p class="text-sm text-gray-600 mt-1">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            @empty
                                <p class="text-sm text-gray-400 py-4">{{ __('shop.no_reviews_yet') }}</p>
                            @endforelse

                            {{-- Review Form --}}
                            <livewire:review-form :productId="$product->id" :wire:key="'review-'.$product->id" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->count() > 0)
        <section class="mt-16">
            <h2 class="font-heading text-2xl font-bold text-gray-900 mb-6">{{ __('shop.related_products') }}</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                @foreach($relatedProducts as $related)
                    <x-product-card :product="$related" />
                @endforeach
            </div>
        </section>
        @endif
    </div>

</x-layouts.app>
