<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Setting;
use App\Models\ShippingZone;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Nature Gold Admin',
            'email' => 'admin@naturegold.in',
            'phone' => '9876543210',
            'role' => UserRole::Admin,
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // Sample customer
        User::create([
            'name' => 'Muthu Kumar',
            'email' => 'muthu@example.com',
            'phone' => '9876543211',
            'role' => UserRole::Customer,
            'locale' => 'ta',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // Sample dealer user
        $dealerUser = User::create([
            'name' => 'Senthil Traders',
            'email' => 'senthil@example.com',
            'phone' => '9876543212',
            'role' => UserRole::Dealer,
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $dealerUser->dealer()->create([
            'business_name' => 'Senthil Traders',
            'gst_number' => '33AABCU9603R1ZP',
            'business_type' => 'wholesale',
            'territory' => 'Chennai',
            'business_address' => '123, Anna Nagar, Chennai - 600040',
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Categories
        $oils = Category::create([
            'name_en' => 'Oils',
            'name_ta' => 'எண்ணெய்கள்',
            'slug' => 'oils',
            'description_en' => 'Pure and natural cold-pressed oils',
            'description_ta' => 'தூய்மையான இயற்கை செக்கு எண்ணெய்கள்',
            'image' => 'categories/oils.jpg',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 1,
        ]);

        $spices = Category::create([
            'name_en' => 'Spices',
            'name_ta' => 'மசாலா பொருட்கள்',
            'slug' => 'spices',
            'description_en' => 'Fresh and aromatic spices',
            'description_ta' => 'புதிய மற்றும் நறுமணமுள்ள மசாலா பொருட்கள்',
            'image' => 'categories/spices.jpg',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 2,
        ]);

        $seeds = Category::create([
            'name_en' => 'Seeds',
            'name_ta' => 'விதைகள்',
            'slug' => 'seeds',
            'description_en' => 'Premium quality seeds',
            'description_ta' => 'உயர்தர விதைகள்',
            'image' => 'categories/seeds.jpg',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 3,
        ]);

        $honey = Category::create([
            'name_en' => 'Honey & Natural Products',
            'name_ta' => 'தேன் & இயற்கை பொருட்கள்',
            'slug' => 'honey-natural-products',
            'description_en' => 'Pure honey and natural food products',
            'description_ta' => 'தூய தேன் மற்றும் இயற்கை உணவுப் பொருட்கள்',
            'image' => 'categories/honey.jpg',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 4,
        ]);

        // Sub-categories for Oils
        Category::create([
            'name_en' => 'Groundnut Oil',
            'name_ta' => 'கடலை எண்ணெய்',
            'slug' => 'groundnut-oil',
            'parent_id' => $oils->id,
            'image' => 'categories/groundnut-oil.jpg',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Category::create([
            'name_en' => 'Sesame Oil',
            'name_ta' => 'நல்லெண்ணெய்',
            'slug' => 'sesame-oil',
            'parent_id' => $oils->id,
            'image' => 'categories/sesame-oil.jpg',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Category::create([
            'name_en' => 'Coconut Oil',
            'name_ta' => 'தேங்காய் எண்ணெய்',
            'slug' => 'coconut-oil',
            'parent_id' => $oils->id,
            'image' => 'categories/coconut-oil.jpg',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        // Sample Products
        $products = [
            [
                'name_en' => 'Nature Gold Cold-Pressed Groundnut Oil',
                'name_ta' => 'நேச்சர் கோல்ட் செக்கு கடலை எண்ணெய்',
                'slug' => 'cold-pressed-groundnut-oil',
                'description_en' => 'Premium cold-pressed groundnut oil extracted using traditional wooden cold press (chekku). Rich in antioxidants and healthy fats. Perfect for all South Indian cooking.',
                'description_ta' => 'பாரம்பரிய மர செக்கு பயன்படுத்தி பிழியப்பட்ட உயர்தர கடலை எண்ணெய். ஆன்டிஆக்ஸிடன்ட்கள் மற்றும் ஆரோக்கியமான கொழுப்புகள் நிறைந்தது.',
                'short_description_en' => '100% pure cold-pressed groundnut oil from Tamil Nadu farms',
                'short_description_ta' => 'தமிழ்நாடு பண்ணைகளிலிருந்து 100% தூய செக்கு கடலை எண்ணெய்',
                'sku' => 'NG-GNO-001',
                'price' => 450.00,
                'sale_price' => 399.00,
                'stock' => 500,
                'unit' => 'ltr',
                'category_id' => $oils->id,
                'is_active' => true,
                'is_featured' => true,
                'is_bestseller' => true,
                'tax_rate' => 5.00,
                'nutritional_info_en' => 'Per 100ml: Energy 900kcal, Total Fat 100g, Saturated Fat 20g, MUFA 50g, PUFA 30g, Vitamin E 15mg',
            ],
            [
                'name_en' => 'Nature Gold Cold-Pressed Sesame Oil',
                'name_ta' => 'நேச்சர் கோல்ட் செக்கு நல்லெண்ணெய்',
                'slug' => 'cold-pressed-sesame-oil',
                'description_en' => 'Authentic cold-pressed sesame oil (Nallennai) made from premium sesame seeds. Traditional extraction preserves natural flavor and nutrients.',
                'description_ta' => 'உயர்தர எள் விதைகளிலிருந்து தயாரிக்கப்பட்ட தூய செக்கு நல்லெண்ணெய். பாரம்பரிய முறையில் பிழியப்படுவதால் இயற்கையான சுவை மற்றும் ஊட்டச்சத்துக்கள் பாதுகாக்கப்படுகின்றன.',
                'short_description_en' => 'Traditional wood-pressed sesame oil (Nallennai)',
                'short_description_ta' => 'பாரம்பரிய மர செக்கு நல்லெண்ணெய்',
                'sku' => 'NG-SEO-001',
                'price' => 520.00,
                'sale_price' => 479.00,
                'stock' => 400,
                'unit' => 'ltr',
                'category_id' => $oils->id,
                'is_active' => true,
                'is_featured' => true,
                'is_bestseller' => true,
                'tax_rate' => 5.00,
            ],
            [
                'name_en' => 'Nature Gold Virgin Coconut Oil',
                'name_ta' => 'நேச்சர் கோல்ட் வெர்ஜின் தேங்காய் எண்ணெய்',
                'slug' => 'virgin-coconut-oil',
                'description_en' => 'Pure virgin coconut oil extracted from fresh coconuts using cold-press method. Ideal for cooking, skin care, and hair care.',
                'description_ta' => 'புதிய தேங்காய்களிலிருந்து செக்கு முறையில் பிழியப்பட்ட தூய வெர்ஜின் தேங்காய் எண்ணெய்.',
                'short_description_en' => 'Multi-purpose virgin coconut oil',
                'short_description_ta' => 'பல்நோக்கு வெர்ஜின் தேங்காய் எண்ணெய்',
                'sku' => 'NG-VCO-001',
                'price' => 380.00,
                'stock' => 300,
                'unit' => 'ltr',
                'category_id' => $oils->id,
                'is_active' => true,
                'is_featured' => true,
                'tax_rate' => 5.00,
            ],
            [
                'name_en' => 'Nature Gold Mustard Oil',
                'name_ta' => 'நேச்சர் கோல்ட் கடுகு எண்ணெய்',
                'slug' => 'cold-pressed-mustard-oil',
                'description_en' => 'Cold-pressed mustard oil with natural pungent flavor. Rich in omega-3 fatty acids.',
                'description_ta' => 'இயற்கையான காரமான சுவையுடன் கூடிய செக்கு கடுகு எண்ணெய்.',
                'sku' => 'NG-MUS-001',
                'price' => 320.00,
                'sale_price' => 299.00,
                'stock' => 250,
                'unit' => 'ltr',
                'category_id' => $oils->id,
                'is_active' => true,
                'tax_rate' => 5.00,
            ],
            [
                'name_en' => 'Nature Gold Premium Turmeric Powder',
                'name_ta' => 'நேச்சர் கோல்ட் உயர்தர மஞ்சள் தூள்',
                'slug' => 'premium-turmeric-powder',
                'description_en' => 'Premium quality turmeric powder from Erode, Tamil Nadu. High curcumin content.',
                'description_ta' => 'ஈரோடு, தமிழ்நாட்டிலிருந்து உயர்தர மஞ்சள் தூள். அதிக குர்குமின் உள்ளடக்கம்.',
                'sku' => 'NG-TUR-001',
                'price' => 180.00,
                'stock' => 600,
                'unit' => 'gm',
                'category_id' => $spices->id,
                'is_active' => true,
                'is_featured' => true,
                'tax_rate' => 5.00,
            ],
            [
                'name_en' => 'Nature Gold White Sesame Seeds',
                'name_ta' => 'நேச்சர் கோல்ட் வெள்ளை எள்',
                'slug' => 'white-sesame-seeds',
                'description_en' => 'Premium hulled white sesame seeds. Rich in calcium and iron.',
                'description_ta' => 'உயர்தர வெள்ளை எள் விதைகள். கால்சியம் மற்றும் இரும்புச்சத்து நிறைந்தது.',
                'sku' => 'NG-WSS-001',
                'price' => 220.00,
                'stock' => 400,
                'unit' => 'gm',
                'category_id' => $seeds->id,
                'is_active' => true,
                'tax_rate' => 5.00,
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create($productData);

            // Add variants for oil products
            if ($product->unit === 'ltr') {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => '200ml',
                    'sku' => $product->sku . '-200ML',
                    'price' => round($product->price * 0.22, 2),
                    'sale_price' => $product->sale_price ? round($product->sale_price * 0.22, 2) : null,
                    'stock' => 200,
                    'weight' => '200ml',
                    'sort_order' => 1,
                ]);

                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => '500ml',
                    'sku' => $product->sku . '-500ML',
                    'price' => round($product->price * 0.52, 2),
                    'sale_price' => $product->sale_price ? round($product->sale_price * 0.52, 2) : null,
                    'stock' => 300,
                    'weight' => '500ml',
                    'sort_order' => 2,
                ]);

                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => '1 Litre',
                    'sku' => $product->sku . '-1L',
                    'price' => $product->price,
                    'sale_price' => $product->sale_price,
                    'stock' => $product->stock,
                    'weight' => '1L',
                    'sort_order' => 3,
                ]);

                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => '5 Litres',
                    'sku' => $product->sku . '-5L',
                    'price' => round($product->price * 4.8, 2),
                    'sale_price' => $product->sale_price ? round($product->sale_price * 4.8, 2) : null,
                    'stock' => 100,
                    'weight' => '5L',
                    'sort_order' => 4,
                ]);
            }

            if ($product->unit === 'gm') {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => '100g',
                    'sku' => $product->sku . '-100G',
                    'price' => round($product->price * 0.45, 2),
                    'stock' => 300,
                    'weight' => '100g',
                    'sort_order' => 1,
                ]);

                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => '250g',
                    'sku' => $product->sku . '-250G',
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'weight' => '250g',
                    'sort_order' => 2,
                ]);

                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => '500g',
                    'sku' => $product->sku . '-500G',
                    'price' => round($product->price * 1.9, 2),
                    'stock' => 200,
                    'weight' => '500g',
                    'sort_order' => 3,
                ]);
            }
        }

        // Product Images
        $productImages = [
            'cold-pressed-groundnut-oil' => 'products/groundnut-oil-1.jpg',
            'cold-pressed-sesame-oil' => 'products/sesame-oil-1.jpg',
            'virgin-coconut-oil' => 'products/coconut-oil-1.jpg',
            'cold-pressed-mustard-oil' => 'products/mustard-oil-1.jpg',
            'premium-turmeric-powder' => 'products/turmeric-1.jpg',
            'white-sesame-seeds' => 'products/sesame-seeds-1.jpg',
        ];

        foreach ($productImages as $slug => $imagePath) {
            $product = Product::where('slug', $slug)->first();
            if ($product) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'is_primary' => true,
                    'sort_order' => 1,
                ]);
            }
        }

        // Banners
        Banner::create([
            'title_en' => '100% Pure Cold-Pressed Oils',
            'title_ta' => '100% தூய செக்கு எண்ணெய்கள்',
            'subtitle_en' => 'From Farm to Your Kitchen - Nature\'s Goodness in Every Drop',
            'subtitle_ta' => 'பண்ணையிலிருந்து உங்கள் சமையலறைக்கு - ஒவ்வொரு துளியிலும் இயற்கையின் நன்மை',
            'image' => 'banners/hero-1.jpg',
            'button_text_en' => 'Shop Now',
            'button_text_ta' => 'இப்போது வாங்குங்கள்',
            'link' => '/shop',
            'position' => 'hero',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Banner::create([
            'title_en' => 'Free Delivery Across Tamil Nadu',
            'title_ta' => 'தமிழ்நாடு முழுவதும் இலவச டெலிவரி',
            'subtitle_en' => 'On orders above Rs.500',
            'subtitle_ta' => 'ரூ.500க்கு மேல் ஆர்டர்களுக்கு',
            'image' => 'banners/hero-2.jpg',
            'button_text_en' => 'Order Now',
            'button_text_ta' => 'இப்போது ஆர்டர் செய்யுங்கள்',
            'link' => '/shop',
            'position' => 'hero',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Banner::create([
            'title_en' => 'Become a Nature Gold Dealer',
            'title_ta' => 'நேச்சர் கோல்ட் டீலர் ஆகுங்கள்',
            'subtitle_en' => 'Join our growing network of dealers across Tamil Nadu',
            'subtitle_ta' => 'தமிழ்நாடு முழுவதும் எங்கள் வளர்ந்து வரும் டீலர் நெட்வொர்க்கில் இணையுங்கள்',
            'image' => 'banners/hero-3.jpg',
            'button_text_en' => 'Apply Now',
            'button_text_ta' => 'இப்போது விண்ணப்பியுங்கள்',
            'link' => '/dealer/register',
            'position' => 'hero',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // CMS Pages
        Page::create([
            'title_en' => 'About Nature Gold',
            'title_ta' => 'நேச்சர் கோல்ட் பற்றி',
            'slug' => 'about',
            'content_en' => '<h2>Our Story</h2><p>Nature Gold is a premium oil brand from Tamil Nadu, dedicated to bringing you the purest cold-pressed oils and natural food products. We use traditional wooden cold-press (chekku/marachekku) methods to extract oils, preserving their natural nutrients, flavor, and aroma.</p><h2>Our Mission</h2><p>To make pure, chemical-free, cold-pressed oils accessible to every household in Tamil Nadu and beyond, while supporting local farmers and preserving traditional oil extraction methods.</p><h2>Why Nature Gold?</h2><ul><li>100% Pure & Natural</li><li>Traditional Cold-Press Method</li><li>No Chemicals or Preservatives</li><li>Farm Fresh Quality</li><li>Lab Tested for Purity</li></ul>',
            'content_ta' => '<h2>எங்கள் கதை</h2><p>நேச்சர் கோல்ட் தமிழ்நாட்டின் உயர்தர எண்ணெய் பிராண்ட், தூய்மையான செக்கு எண்ணெய்கள் மற்றும் இயற்கை உணவுப் பொருட்களை உங்களுக்கு வழங்க அர்ப்பணிக்கப்பட்டது.</p>',
            'is_active' => true,
        ]);

        Page::create([
            'title_en' => 'Privacy Policy',
            'title_ta' => 'தனியுரிமை கொள்கை',
            'slug' => 'privacy-policy',
            'content_en' => '<h2>Privacy Policy</h2><p>At Nature Gold, we are committed to protecting your privacy. This policy outlines how we collect, use, and safeguard your personal information.</p>',
            'is_active' => true,
        ]);

        Page::create([
            'title_en' => 'Terms & Conditions',
            'title_ta' => 'விதிமுறைகள் & நிபந்தனைகள்',
            'slug' => 'terms-conditions',
            'content_en' => '<h2>Terms & Conditions</h2><p>By using Nature Gold website, you agree to the following terms and conditions.</p>',
            'is_active' => true,
        ]);

        Page::create([
            'title_en' => 'Refund Policy',
            'title_ta' => 'பணத்திரும்ப கொள்கை',
            'slug' => 'refund-policy',
            'content_en' => '<h2>Refund Policy</h2><p>We want you to be completely satisfied with your purchase. If you receive a damaged or incorrect product, we offer a full refund or replacement.</p>',
            'is_active' => true,
        ]);

        Page::create([
            'title_en' => 'Shipping Policy',
            'title_ta' => 'ஷிப்பிங் கொள்கை',
            'slug' => 'shipping-policy',
            'content_en' => '<h2>Shipping Policy</h2><p>We deliver across Tamil Nadu and all major cities in India. Free delivery on orders above Rs.500 within Tamil Nadu.</p>',
            'is_active' => true,
        ]);

        // Shipping Zones - Tamil Nadu
        ShippingZone::create([
            'name' => 'Chennai Metro',
            'districts' => ['Chennai', 'Chengalpattu', 'Tiruvallur', 'Kancheepuram'],
            'base_rate' => 40.00,
            'per_kg_rate' => 5.00,
            'free_above' => 300.00,
            'estimated_days' => '1-2 days',
            'is_active' => true,
        ]);

        ShippingZone::create([
            'name' => 'Tamil Nadu - Zone A',
            'districts' => ['Coimbatore', 'Madurai', 'Tiruchirappalli', 'Salem', 'Tiruppur', 'Erode', 'Vellore', 'Thanjavur'],
            'base_rate' => 60.00,
            'per_kg_rate' => 8.00,
            'free_above' => 500.00,
            'estimated_days' => '2-3 days',
            'is_active' => true,
        ]);

        ShippingZone::create([
            'name' => 'Tamil Nadu - Zone B',
            'districts' => ['Dindigul', 'Karur', 'Namakkal', 'Dharmapuri', 'Krishnagiri', 'Tiruvannamalai', 'Viluppuram', 'Cuddalore', 'Nagapattinam', 'Tiruvarur', 'Pudukkottai', 'Sivagangai', 'Ramanathapuram', 'Virudhunagar', 'Theni', 'Tirunelveli', 'Thoothukudi', 'Tenkasi', 'Nilgiris', 'Ariyalur', 'Perambalur', 'Kallakurichi', 'Mayiladuthurai', 'Ranipet', 'Tirupathur'],
            'base_rate' => 80.00,
            'per_kg_rate' => 10.00,
            'free_above' => 500.00,
            'estimated_days' => '3-5 days',
            'is_active' => true,
        ]);

        ShippingZone::create([
            'name' => 'Rest of India',
            'districts' => ['Other'],
            'base_rate' => 120.00,
            'per_kg_rate' => 15.00,
            'free_above' => 1000.00,
            'estimated_days' => '5-7 days',
            'is_active' => true,
        ]);

        // Settings
        $settings = [
            ['group' => 'general', 'key' => 'store_name', 'value' => 'Nature Gold'],
            ['group' => 'general', 'key' => 'store_email', 'value' => 'info@naturegold.in'],
            ['group' => 'general', 'key' => 'store_phone', 'value' => '+91 98765 43210'],
            ['group' => 'general', 'key' => 'store_whatsapp', 'value' => '+919876543210'],
            ['group' => 'general', 'key' => 'store_address', 'value' => 'Nature Gold, Chennai, Tamil Nadu, India'],
            ['group' => 'general', 'key' => 'store_gst', 'value' => '33AABCU9603R1ZP'],
            ['group' => 'general', 'key' => 'currency', 'value' => 'INR'],
            ['group' => 'general', 'key' => 'currency_symbol', 'value' => '₹'],
            ['group' => 'social', 'key' => 'facebook_url', 'value' => 'https://facebook.com/naturegold'],
            ['group' => 'social', 'key' => 'instagram_url', 'value' => 'https://instagram.com/naturegold'],
            ['group' => 'social', 'key' => 'youtube_url', 'value' => 'https://youtube.com/@naturegold'],
            ['group' => 'payment', 'key' => 'razorpay_key', 'value' => ''],
            ['group' => 'payment', 'key' => 'razorpay_secret', 'value' => ''],
            ['group' => 'payment', 'key' => 'phonepe_merchant_id', 'value' => ''],
            ['group' => 'payment', 'key' => 'cod_enabled', 'value' => 'true'],
            ['group' => 'payment', 'key' => 'cod_charge', 'value' => '30'],
            ['group' => 'shipping', 'key' => 'default_tax_rate', 'value' => '5'],
            ['group' => 'whatsapp', 'key' => 'whatsapp_api_token', 'value' => ''],
            ['group' => 'whatsapp', 'key' => 'whatsapp_phone_id', 'value' => ''],
            ['group' => 'whatsapp', 'key' => 'whatsapp_business_id', 'value' => ''],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
