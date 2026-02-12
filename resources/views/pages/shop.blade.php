<x-layouts.app :title="$currentCategory ? $currentCategory->name : __('shop.all_products')">

    <div class="max-w-7xl mx-auto px-4 py-8">
        {{-- Breadcrumb --}}
        <nav class="text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-gold-600">{{ __('shop.nav_home') }}</a>
            <span class="mx-2">/</span>
            @if($currentCategory)
                <a href="{{ route('shop') }}" class="hover:text-gold-600">{{ __('shop.nav_shop') }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800 font-medium">{{ $currentCategory->name }}</span>
            @else
                <span class="text-gray-800 font-medium">{{ __('shop.nav_shop') }}</span>
            @endif
        </nav>

        <div class="lg:flex gap-8">
            {{-- Sidebar Filters (Desktop) --}}
            <aside class="hidden lg:block w-64 shrink-0">
                <form method="GET" action="{{ route('shop') }}">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                        <h3 class="font-heading font-bold text-gray-900 mb-4">{{ __('shop.nav_categories') }}</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('shop') }}" class="text-sm {{ !$currentCategory ? 'text-gold-600 font-semibold' : 'text-gray-600 hover:text-gold-600' }}">
                                    {{ __('shop.all_products') }}
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('shop', ['category' => $category->slug]) }}"
                                       class="text-sm {{ $currentCategory?->id === $category->id ? 'text-gold-600 font-semibold' : 'text-gray-600 hover:text-gold-600' }}">
                                        {{ $category->name }}
                                    </a>
                                    @if($category->children->count() > 0)
                                        <ul class="pl-4 mt-1 space-y-1">
                                            @foreach($category->children as $child)
                                                <li>
                                                    <a href="{{ route('shop', ['category' => $child->slug]) }}"
                                                       class="text-xs {{ $currentCategory?->id === $child->id ? 'text-gold-600 font-semibold' : 'text-gray-500 hover:text-gold-600' }}">
                                                        {{ $child->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 mt-4">
                        <h3 class="font-heading font-bold text-gray-900 mb-4">{{ __('shop.price_range') }}</h3>
                        <div class="flex gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg">
                        </div>
                        <button type="submit" class="mt-3 w-full py-2 bg-gold-500 text-white text-sm font-medium rounded-lg hover:bg-gold-600 transition">
                            {{ __('shop.apply') }}
                        </button>
                        @if(request('min_price') || request('max_price'))
                            <a href="{{ route('shop', request()->only('category', 'search', 'sort')) }}" class="block mt-2 text-center text-xs text-gray-500 hover:text-red-500">
                                {{ __('shop.clear_filters') }}
                            </a>
                        @endif
                    </div>
                </form>
            </aside>

            {{-- Products Grid --}}
            <div class="flex-1">
                {{-- Sort & Count Bar --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                    <p class="text-sm text-gray-500">
                        {{ __('shop.showing_results', ['count' => $products->total()]) }}
                    </p>
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-500 hidden sm:inline">{{ __('shop.sort_by') }}:</label>
                        <select onchange="window.location.href=this.value" class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 focus:border-gold-400 outline-none w-full sm:w-auto">
                            <option value="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>{{ __('shop.sort_newest') }}</option>
                            <option value="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}" {{ request('sort') === 'price_low' ? 'selected' : '' }}>{{ __('shop.sort_price_low') }}</option>
                            <option value="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}" {{ request('sort') === 'price_high' ? 'selected' : '' }}>{{ __('shop.sort_price_high') }}</option>
                            <option value="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'popular'])) }}" {{ request('sort') === 'popular' ? 'selected' : '' }}>{{ __('shop.sort_popular') }}</option>
                        </select>
                    </div>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-20">
                        <svg class="w-20 h-20 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <p class="text-gray-500 mt-4 font-medium">{{ __('shop.no_products') }}</p>
                        <a href="{{ route('shop') }}" class="inline-block mt-4 px-6 py-2 bg-gold-500 text-white rounded-lg text-sm font-medium hover:bg-gold-600 transition">
                            {{ __('shop.clear_filters') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-layouts.app>
