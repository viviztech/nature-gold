<?php

namespace App\Http\Controllers;

use App\Enums\DealerStatus;
use App\Enums\TamilNaduDistrict;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Dealer;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StorefrontController extends Controller
{
    public function home()
    {
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => 'Nature Gold Deepam Lamp Oil',
            'description' => __('shop.deepam_hero_desc'),
            'brand' => [
                '@type' => 'Brand',
                'name' => 'Nature Gold',
            ],
            'manufacturer' => [
                '@type' => 'Organization',
                'name' => 'Nature Care FMCG Products',
            ],
        ];

        $products = [
            [
                'size' => '200ml',
                'image' => asset('images/products/deepam-oil-200ml.png'),
            ],
            [
                'size' => '500ml',
                'image' => asset('images/products/deepam-oil-500ml.png'),
            ],
            [
                'size' => '1000ml',
                'image' => asset('images/products/deepam-oil-1000ml.png'),
            ],
        ];

        return view('pages.home', compact('products', 'jsonLd'));
    }

    public function upcomingProducts()
    {
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Nature Gold',
            'description' => __('shop.seo_home_description'),
            'url' => url('/'),
        ];

        $banners = Cache::remember('home:banners', 600, fn () =>
            Banner::where('is_active', true)
                ->where('position', 'hero')
                ->where(fn ($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
                ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>=', now()))
                ->orderBy('sort_order')
                ->get()
        );

        $categories = Cache::remember('home:categories', 600, fn () =>
            Category::active()->roots()->ordered()
                ->withCount('products')
                ->get()
        );

        $featuredProducts = Cache::remember('home:featured', 300, fn () =>
            Product::where('is_active', true)
                ->where('is_featured', true)
                ->with(['primaryImage', 'category', 'variants'])
                ->limit(8)
                ->get()
        );

        $bestSellers = Cache::remember('home:bestsellers', 300, fn () =>
            Product::where('is_active', true)
                ->withCount('orderItems')
                ->orderByDesc('order_items_count')
                ->with(['primaryImage', 'category', 'variants'])
                ->limit(8)
                ->get()
        );

        return view('pages.upcoming-products', compact('banners', 'categories', 'featuredProducts', 'bestSellers', 'jsonLd'));
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

    public function findDealer(Request $request)
    {
        $district = $request->query('district');
        $districts = TamilNaduDistrict::cases();

        $query = Dealer::where('status', DealerStatus::Approved)
            ->with('user:id,name');

        if ($district) {
            $query->where('territory', $district);
        }

        $dealers = $query->orderBy('territory')->orderBy('business_name')->get();
        $grouped = $dealers->groupBy('territory');

        return view('pages.find-dealer', compact('grouped', 'districts', 'district'));
    }
}
