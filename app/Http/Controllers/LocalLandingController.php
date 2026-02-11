<?php

namespace App\Http\Controllers;

use App\Models\Product;

class LocalLandingController extends Controller
{
    /**
     * Tamil Nadu districts with SEO-relevant data.
     */
    private const DISTRICTS = [
        'chennai' => ['name_en' => 'Chennai', 'name_ta' => 'சென்னை', 'region' => 'north'],
        'coimbatore' => ['name_en' => 'Coimbatore', 'name_ta' => 'கோயம்புத்தூர்', 'region' => 'west'],
        'madurai' => ['name_en' => 'Madurai', 'name_ta' => 'மதுரை', 'region' => 'south'],
        'tiruchirappalli' => ['name_en' => 'Tiruchirappalli', 'name_ta' => 'திருச்சிராப்பள்ளி', 'region' => 'central'],
        'salem' => ['name_en' => 'Salem', 'name_ta' => 'சேலம்', 'region' => 'west'],
        'tirunelveli' => ['name_en' => 'Tirunelveli', 'name_ta' => 'திருநெல்வேலி', 'region' => 'south'],
        'erode' => ['name_en' => 'Erode', 'name_ta' => 'ஈரோடு', 'region' => 'west'],
        'vellore' => ['name_en' => 'Vellore', 'name_ta' => 'வேலூர்', 'region' => 'north'],
        'thoothukudi' => ['name_en' => 'Thoothukudi', 'name_ta' => 'தூத்துக்குடி', 'region' => 'south'],
        'thanjavur' => ['name_en' => 'Thanjavur', 'name_ta' => 'தஞ்சாவூர்', 'region' => 'central'],
        'dindigul' => ['name_en' => 'Dindigul', 'name_ta' => 'திண்டுக்கல்', 'region' => 'south'],
        'kanchipuram' => ['name_en' => 'Kanchipuram', 'name_ta' => 'காஞ்சிபுரம்', 'region' => 'north'],
        'cuddalore' => ['name_en' => 'Cuddalore', 'name_ta' => 'கடலூர்', 'region' => 'north'],
        'tiruppur' => ['name_en' => 'Tiruppur', 'name_ta' => 'திருப்பூர்', 'region' => 'west'],
        'villupuram' => ['name_en' => 'Villupuram', 'name_ta' => 'விழுப்புரம்', 'region' => 'north'],
        'nagapattinam' => ['name_en' => 'Nagapattinam', 'name_ta' => 'நாகப்பட்டினம்', 'region' => 'central'],
        'sivaganga' => ['name_en' => 'Sivaganga', 'name_ta' => 'சிவகங்கை', 'region' => 'south'],
        'namakkal' => ['name_en' => 'Namakkal', 'name_ta' => 'நாமக்கல்', 'region' => 'west'],
        'theni' => ['name_en' => 'Theni', 'name_ta' => 'தேனி', 'region' => 'south'],
        'virudhunagar' => ['name_en' => 'Virudhunagar', 'name_ta' => 'விருதுநகர்', 'region' => 'south'],
        'karur' => ['name_en' => 'Karur', 'name_ta' => 'கரூர்', 'region' => 'central'],
        'krishnagiri' => ['name_en' => 'Krishnagiri', 'name_ta' => 'கிருஷ்ணகிரி', 'region' => 'north'],
        'dharmapuri' => ['name_en' => 'Dharmapuri', 'name_ta' => 'தர்மபுரி', 'region' => 'north'],
        'ramanathapuram' => ['name_en' => 'Ramanathapuram', 'name_ta' => 'ராமநாதபுரம்', 'region' => 'south'],
        'perambalur' => ['name_en' => 'Perambalur', 'name_ta' => 'பெரம்பலூர்', 'region' => 'central'],
        'ariyalur' => ['name_en' => 'Ariyalur', 'name_ta' => 'அரியலூர்', 'region' => 'central'],
        'the-nilgiris' => ['name_en' => 'The Nilgiris', 'name_ta' => 'நீலகிரி', 'region' => 'west'],
        'tiruvannamalai' => ['name_en' => 'Tiruvannamalai', 'name_ta' => 'திருவண்ணாமலை', 'region' => 'north'],
        'pudukkottai' => ['name_en' => 'Pudukkottai', 'name_ta' => 'புதுக்கோட்டை', 'region' => 'central'],
        'tiruvallur' => ['name_en' => 'Tiruvallur', 'name_ta' => 'திருவள்ளூர்', 'region' => 'north'],
        'ranipet' => ['name_en' => 'Ranipet', 'name_ta' => 'ராணிப்பேட்டை', 'region' => 'north'],
        'tirupattur' => ['name_en' => 'Tirupattur', 'name_ta' => 'திருப்பத்தூர்', 'region' => 'north'],
        'tenkasi' => ['name_en' => 'Tenkasi', 'name_ta' => 'தென்காசி', 'region' => 'south'],
        'chengalpattu' => ['name_en' => 'Chengalpattu', 'name_ta' => 'செங்கல்பட்டு', 'region' => 'north'],
        'kallakurichi' => ['name_en' => 'Kallakurichi', 'name_ta' => 'கள்ளக்குறிச்சி', 'region' => 'north'],
        'mayiladuthurai' => ['name_en' => 'Mayiladuthurai', 'name_ta' => 'மயிலாடுதுறை', 'region' => 'central'],
        'kanyakumari' => ['name_en' => 'Kanyakumari', 'name_ta' => 'கன்னியாகுமரி', 'region' => 'south'],
        'tiruvarur' => ['name_en' => 'Tiruvarur', 'name_ta' => 'திருவாரூர்', 'region' => 'central'],
    ];

    /**
     * Product keywords for landing page SEO.
     */
    private const PRODUCT_TYPES = [
        'cold-pressed-oil' => ['en' => 'Cold Pressed Oil', 'ta' => 'செக்கு எண்ணெய்'],
        'groundnut-oil' => ['en' => 'Groundnut Oil', 'ta' => 'நிலக்கடலை எண்ணெய்'],
        'sesame-oil' => ['en' => 'Sesame Oil', 'ta' => 'நல்லெண்ணெய்'],
        'coconut-oil' => ['en' => 'Coconut Oil', 'ta' => 'தேங்காய் எண்ணெய்'],
    ];

    /**
     * Show the district landing page index.
     */
    public function index()
    {
        $districts = self::DISTRICTS;

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Nature Gold',
            'description' => __('shop.seo_local_description'),
            'url' => url('/'),
            'areaServed' => array_map(fn ($d) => [
                '@type' => 'Place',
                'name' => $d['name_en'] . ', Tamil Nadu',
            ], $districts),
        ];

        return view('pages.local.index', compact('districts', 'jsonLd'));
    }

    /**
     * Show a district-specific landing page.
     */
    public function show(string $district)
    {
        if (! isset(self::DISTRICTS[$district])) {
            abort(404);
        }

        $districtData = self::DISTRICTS[$district];
        $districtName = app()->getLocale() === 'ta' ? $districtData['name_ta'] : $districtData['name_en'];
        $productTypes = self::PRODUCT_TYPES;

        $products = Product::where('is_active', true)
            ->with(['primaryImage', 'category', 'variants'])
            ->limit(8)
            ->get();

        $nearbyDistricts = collect(self::DISTRICTS)
            ->filter(fn ($d, $slug) => $d['region'] === $districtData['region'] && $slug !== $district)
            ->take(6);

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => 'Nature Gold - ' . $districtData['name_en'],
            'description' => __('shop.local_meta_description', ['district' => $districtName]),
            'url' => route('local.show', $district),
            'areaServed' => [
                '@type' => 'Place',
                'name' => $districtData['name_en'] . ', Tamil Nadu, India',
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'addressRegion' => 'Tamil Nadu',
                'addressCountry' => 'IN',
            ],
        ];

        return view('pages.local.show', compact(
            'district', 'districtData', 'districtName', 'products',
            'productTypes', 'nearbyDistricts', 'jsonLd'
        ));
    }

    /**
     * Show a product-type + district landing page.
     */
    public function productType(string $productType, string $district)
    {
        if (! isset(self::DISTRICTS[$district]) || ! isset(self::PRODUCT_TYPES[$productType])) {
            abort(404);
        }

        $districtData = self::DISTRICTS[$district];
        $productTypeData = self::PRODUCT_TYPES[$productType];
        $districtName = app()->getLocale() === 'ta' ? $districtData['name_ta'] : $districtData['name_en'];
        $productTypeName = app()->getLocale() === 'ta' ? $productTypeData['ta'] : $productTypeData['en'];

        $products = Product::where('is_active', true)
            ->with(['primaryImage', 'category', 'variants'])
            ->limit(12)
            ->get();

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $productTypeName . ' - Nature Gold ' . $districtData['name_en'],
            'description' => __('shop.local_product_meta', ['product' => $productTypeName, 'district' => $districtName]),
            'brand' => ['@type' => 'Brand', 'name' => 'Nature Gold'],
        ];

        return view('pages.local.product-type', compact(
            'district', 'districtData', 'districtName',
            'productType', 'productTypeData', 'productTypeName',
            'products', 'jsonLd'
        ));
    }
}
