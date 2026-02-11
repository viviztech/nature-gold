<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create();

        // Static pages
        $sitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency('daily'));
        $sitemap->add(Url::create('/shop')->setPriority(0.9)->setChangeFrequency('daily'));
        $sitemap->add(Url::create('/about')->setPriority(0.7)->setChangeFrequency('monthly'));
        $sitemap->add(Url::create('/contact')->setPriority(0.6)->setChangeFrequency('monthly'));
        $sitemap->add(Url::create('/blog')->setPriority(0.8)->setChangeFrequency('daily'));

        // Tamil versions
        $sitemap->add(Url::create('/ta')->setPriority(0.9)->setChangeFrequency('daily'));
        $sitemap->add(Url::create('/ta/shop')->setPriority(0.8)->setChangeFrequency('daily'));
        $sitemap->add(Url::create('/ta/about')->setPriority(0.6)->setChangeFrequency('monthly'));
        $sitemap->add(Url::create('/ta/contact')->setPriority(0.5)->setChangeFrequency('monthly'));
        $sitemap->add(Url::create('/ta/blog')->setPriority(0.7)->setChangeFrequency('daily'));

        // Products
        Product::where('is_active', true)->each(function (Product $product) use ($sitemap) {
            $sitemap->add(
                Url::create("/product/{$product->slug}")
                    ->setLastModificationDate($product->updated_at)
                    ->setPriority(0.8)
                    ->setChangeFrequency('weekly')
            );

            // Tamil product page
            $sitemap->add(
                Url::create("/ta/product/{$product->slug}")
                    ->setLastModificationDate($product->updated_at)
                    ->setPriority(0.7)
                    ->setChangeFrequency('weekly')
            );
        });

        // Categories as shop filters
        Category::where('is_active', true)->each(function (Category $category) use ($sitemap) {
            $sitemap->add(
                Url::create("/shop?category={$category->slug}")
                    ->setLastModificationDate($category->updated_at)
                    ->setPriority(0.7)
                    ->setChangeFrequency('weekly')
            );
        });

        // Blog posts
        BlogPost::published()->each(function (BlogPost $post) use ($sitemap) {
            $sitemap->add(
                Url::create("/blog/{$post->slug}")
                    ->setLastModificationDate($post->updated_at)
                    ->setPriority(0.7)
                    ->setChangeFrequency('weekly')
            );

            $sitemap->add(
                Url::create("/ta/blog/{$post->slug}")
                    ->setLastModificationDate($post->updated_at)
                    ->setPriority(0.6)
                    ->setChangeFrequency('weekly')
            );
        });

        // Local landing pages
        $sitemap->add(Url::create('/locations')->setPriority(0.7)->setChangeFrequency('monthly'));
        $districts = [
            'chennai', 'coimbatore', 'madurai', 'tiruchirappalli', 'salem',
            'tirunelveli', 'erode', 'vellore', 'thoothukudi', 'thanjavur',
            'dindigul', 'kanchipuram', 'cuddalore', 'tiruppur', 'villupuram',
            'nagapattinam', 'sivaganga', 'namakkal', 'theni', 'virudhunagar',
            'karur', 'krishnagiri', 'dharmapuri', 'ramanathapuram', 'perambalur',
            'ariyalur', 'the-nilgiris', 'tiruvannamalai', 'pudukkottai',
            'tiruvallur', 'ranipet', 'tirupattur', 'tenkasi', 'chengalpattu',
            'kallakurichi', 'mayiladuthurai', 'kanyakumari', 'tiruvarur',
        ];
        foreach ($districts as $district) {
            $sitemap->add(
                Url::create("/locations/{$district}")
                    ->setPriority(0.6)
                    ->setChangeFrequency('monthly')
            );
        }

        $productTypes = ['cold-pressed-oil', 'groundnut-oil', 'sesame-oil', 'coconut-oil'];
        foreach ($productTypes as $type) {
            foreach (['chennai', 'coimbatore', 'madurai', 'tiruchirappalli', 'salem', 'tirunelveli'] as $topDistrict) {
                $sitemap->add(
                    Url::create("/{$type}/{$topDistrict}")
                        ->setPriority(0.5)
                        ->setChangeFrequency('monthly')
                );
            }
        }

        // CMS Pages
        Page::where('is_active', true)->each(function (Page $page) use ($sitemap) {
            $sitemap->add(
                Url::create("/page/{$page->slug}")
                    ->setLastModificationDate($page->updated_at)
                    ->setPriority(0.5)
                    ->setChangeFrequency('monthly')
            );
        });

        return $sitemap->toResponse(request());
    }
}
