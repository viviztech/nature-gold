<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;

class StorefrontController extends Controller
{
    public function home()
    {
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Nature Gold',
            'description' => __('shop.seo_home_description'),
            'url' => url('/'),
        ];
        $banners = Banner::where('is_active', true)
            ->where('position', 'hero')
            ->where(fn ($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>=', now()))
            ->orderBy('sort_order')
            ->get();

        $categories = Category::active()->roots()->ordered()
            ->withCount('products')
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with(['primaryImage', 'category', 'variants'])
            ->limit(8)
            ->get();

        $bestSellers = Product::where('is_active', true)
            ->withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->with(['primaryImage', 'category', 'variants'])
            ->limit(8)
            ->get();

        return view('pages.home', compact('banners', 'categories', 'featuredProducts', 'bestSellers', 'jsonLd'));
    }

    public function about()
    {
        $page = Page::where('slug', 'about-us')->first();

        return view('pages.about', compact('page'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function page(string $slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('pages.static', compact('page'));
    }
}
