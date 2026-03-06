<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductBulkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        Product::truncate();
        Category::truncate();
        
        $this->command->info('Importing categories with hierarchy...');
        
        // Import categories with hierarchy
        $categories = $this->getCategoriesData();
        
        $categoryIdMap = [];
        
        foreach ($categories as $categoryData) {
            $oldId = $categoryData['id'];
            unset($categoryData['id']);
            
            // Handle parent_id - we'll map after creating all categories
            $parentId = $categoryData['parent_id'];
            unset($categoryData['parent_id']);
            
            $category = Category::create($categoryData);
            $categoryIdMap[$oldId] = $category->id;
            
            $this->command->line("Created category: {$category->name_en}");
        }
        
        // Update parent_ids with new mapped IDs
        foreach ($categoryIdMap as $oldId => $newId) {
            $category = Category::find($newId);
            if ($category) {
                // Find which category had this as parent
                foreach ($categories as $catData) {
                    if ($catData['parent_id'] == $oldId && $catData['parent_id'] != 0) {
                        // Find the child category and update its parent
                        $childOldId = $catData['id'];
                        $child = Category::find($categoryIdMap[$childOldId]);
                        if ($child && isset($categoryIdMap[$oldId])) {
                            $child->parent_id = $categoryIdMap[$oldId];
                            $child->save();
                            $this->command->line("  └─ Updated parent for: {$child->name_en}");
                        }
                    }
                }
            }
        }
        
        $this->command->info('Importing products...');
        
        // Import products
        $products = $this->getProductsData();
        
        foreach ($products as $productData) {
            // Map old category_id to new category_id
            $oldCategoryId = $productData['category_id'];
            $productData['category_id'] = isset($categoryIdMap[$oldCategoryId]) ? $categoryIdMap[$oldCategoryId] : null;
            
            // Generate slug if not provided
            if (empty($productData['slug'])) {
                $productData['slug'] = Str::slug($productData['name_en']);
            }
            
            Product::create($productData);
            $this->command->line("Created product: {$productData['name_en']}");
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('Bulk import completed successfully!');
        $this->command->info('Categories imported: ' . count($categories));
        $this->command->info('Products imported: ' . count($products));
    }
    
    /**
     * Get categories data from CSV file
     */
    private function getCategoriesData(): array
    {
        $file = database_path('seeders/data/categories.csv');
        
        if (!file_exists($file)) {
            return $this->getDefaultCategoriesData();
        }
        
        $handle = fopen($file, 'r');
        $headers = fgetcsv($handle);
        $categories = [];
        
        while (($row = fgetcsv($handle)) !== false) {
            $categories[] = array_combine($headers, $row);
        }
        
        fclose($handle);
        
        return $categories;
    }
    
    /**
     * Get products data from CSV file
     */
    private function getProductsData(): array
    {
        $file = database_path('seeders/data/products.csv');
        
        if (!file_exists($file)) {
            return $this->getDefaultProductsData();
        }
        
        $handle = fopen($file, 'r');
        $headers = fgetcsv($handle);
        $products = [];
        
        while (($row = fgetcsv($handle)) !== false) {
            $products[] = array_combine($headers, $row);
        }
        
        fclose($handle);
        
        return $products;
    }
    
    /**
     * Default categories data (fallback if CSV not found)
     */
    private function getDefaultCategoriesData(): array
    {
        return [
            // Main categories (parent_id = 0)
            [
                'id' => 1,
                'name_en' => 'Spices & Masalas',
                'name_ta' => 'மசாலா மற்றும் வாசனை திரவியங்கள்',
                'slug' => 'spices-masalas',
                'description_en' => 'Premium quality spices and masala powders sourced from across India.',
                'description_ta' => 'இந்தியா முழுவதும் இருந்து பெறப்படும் உயர்ந்த தரமான மசாலா.',
                'parent_id' => 0,
                'is_active' => true,
                'sort_order' => 1,
                'is_featured' => true,
                'meta_title' => 'Spices & Masalas - Buy Online',
                'meta_description' => 'Premium spices and masalas online at best price',
            ],
            [
                'id' => 2,
                'name_en' => 'Cleaning Products',
                'name_ta' => 'சுத்தப்படுத்தும் பொருட்கள்',
                'slug' => 'cleaning-products',
                'description_en' => 'Complete range of cleaning products for home and commercial use.',
                'description_ta' => 'வீடு மற்றும் வணிக பயன்பாட்டிற்கான முழுமையான சுத்தப்படுத்தும் பொருட்கள்.',
                'parent_id' => 0,
                'is_active' => true,
                'sort_order' => 2,
                'is_featured' => true,
                'meta_title' => 'Cleaning Products - Naturecare',
                'meta_description' => 'Buy cleaning products online at best price',
            ],
            [
                'id' => 3,
                'name_en' => 'Personal Care & Hygiene',
                'name_ta' => 'தனிப்பட்ட பராமரிப்பு மற்றும் சுகாதாரம்',
                'slug' => 'personal-care-hygiene',
                'description_en' => 'Personal care and hygiene products for daily use.',
                'description_ta' => 'தினசரி பயன்பாட்டிற்கான தனிப்பட்ட பராமரிப்பு மற்றும் சுகாதார பொருட்கள்.',
                'parent_id' => 0,
                'is_active' => true,
                'sort_order' => 3,
                'is_featured' => true,
                'meta_title' => 'Personal Care & Hygiene - Naturecare',
                'meta_description' => 'Buy personal care and hygiene products online',
            ],
            [
                'id' => 4,
                'name_en' => 'Hair Care',
                'name_ta' => 'முடி பராமரிப்பு',
                'slug' => 'hair-care',
                'description_en' => 'Natural and chemical-free hair care products.',
                'description_ta' => 'இயற்கை மற்றும் இரசாயனம் இல்லாத முடி பராமரிப்பு பொருட்கள்.',
                'parent_id' => 0,
                'is_active' => true,
                'sort_order' => 4,
                'is_featured' => true,
                'meta_title' => 'Hair Care Products - Naturecare',
                'meta_description' => 'Buy natural hair care products online',
            ],
            [
                'id' => 5,
                'name_en' => 'Laundry Care',
                'name_ta' => 'துவைப்பு பராமரிப்பு',
                'slug' => 'laundry-care',
                'description_en' => 'Laundry care products for clean and fresh clothes.',
                'description_ta' => 'சுத்தமான மற்றும் புதிய ஆடைகளுக்கான துவைப்பு பராமரிப்பு பொருட்கள்.',
                'parent_id' => 0,
                'is_active' => true,
                'sort_order' => 5,
                'is_featured' => false,
                'meta_title' => 'Laundry Care Products - Naturecare',
                'meta_description' => 'Buy laundry care products online at best price',
            ],
            [
                'id' => 6,
                'name_en' => 'Air Fresheners',
                'name_ta' => 'காற்று புதுப்பிப்பான்கள்',
                'slug' => 'air-fresheners',
                'description_en' => 'Room fresheners with various fragrances.',
                'description_ta' => 'பல்வேறு வாசனைகளுடன் அறை புதுப்பிப்பான்கள்.',
                'parent_id' => 0,
                'is_active' => true,
                'sort_order' => 6,
                'is_featured' => false,
                'meta_title' => 'Air Fresheners - Naturecare',
                'meta_description' => 'Buy room fresheners online at best price',
            ],
            
            // Sub-categories under Cleaning Products (parent_id = 2)
            [
                'id' => 7,
                'name_en' => 'Floor Cleaners',
                'name_ta' => 'தரை சுத்தப்படுத்திகள்',
                'slug' => 'floor-cleaners',
                'description_en' => 'Advanced formula floor cleaners with various fragrances.',
                'description_ta' => 'பல்வேறு வாசனைகளுடன் மேம்பட்ட சூத்திர தரை சுத்தப்படுத்திகள்.',
                'parent_id' => 2,
                'is_active' => true,
                'sort_order' => 1,
                'is_featured' => true,
                'meta_title' => 'Floor Cleaners - Naturecare',
                'meta_description' => 'Buy floor cleaners online at best price',
            ],
            [
                'id' => 8,
                'name_en' => 'Phenyl & Disinfectants',
                'name_ta' => 'ஃபீனைல் மற்றும் கிருமிநாசினிகள்',
                'slug' => 'phenyl-disinfectants',
                'description_en' => 'Powerful phenyl and disinfectants for bathrooms and floors.',
                'description_ta' => 'குளியலறைகள் மற்றும் தரைகளுக்கான சக்திவாய்ந்த ஃபீனைல்.',
                'parent_id' => 2,
                'is_active' => true,
                'sort_order' => 2,
                'is_featured' => true,
                'meta_title' => 'Phenyl & Disinfectants - Naturecare',
                'meta_description' => 'Buy phenyl and disinfectants online',
            ],
            [
                'id' => 9,
                'name_en' => 'Toilet & Bathroom Cleaners',
                'name_ta' => 'டாய்லெட் மற்றும் குளியறை சுத்தப்படுத்திகள்',
                'slug' => 'toilet-bathroom-cleaners',
                'description_en' => 'Specialized cleaners for toilets and bathrooms.',
                'description_ta' => 'டாய்லெட் மற்றும் குளியறைகளுக்கான சிறப்பு சுத்தப்படுத்திகள்.',
                'parent_id' => 2,
                'is_active' => true,
                'sort_order' => 3,
                'is_featured' => true,
                'meta_title' => 'Toilet & Bathroom Cleaners - Naturecare',
                'meta_description' => 'Buy toilet and bathroom cleaners online',
            ],
            [
                'id' => 10,
                'name_en' => 'Dish Washing',
                'name_ta' => 'பாத்திரம் கழுவுதல்',
                'slug' => 'dish-washing',
                'description_en' => 'Dish washing gels and liquids.',
                'description_ta' => 'பாத்திரம் கழுவும் ஜெல் மற்றும் லிக்விட்.',
                'parent_id' => 2,
                'is_active' => true,
                'sort_order' => 4,
                'is_featured' => false,
                'meta_title' => 'Dish Washing Products - Naturecare',
                'meta_description' => 'Buy dish washing products online',
            ],
            [
                'id' => 11,
                'name_en' => 'Glass & Surface Cleaners',
                'name_ta' => 'கண்ணாடி மற்றும் பரப்பு சுத்தப்படுத்திகள்',
                'slug' => 'glass-surface-cleaners',
                'description_en' => 'Streak-free glass cleaners and multipurpose surface cleaners.',
                'description_ta' => 'பட்டை இல்லாத கண்ணாடி சுத்தப்படுத்திகள்.',
                'parent_id' => 2,
                'is_active' => true,
                'sort_order' => 5,
                'is_featured' => false,
                'meta_title' => 'Glass & Surface Cleaners - Naturecare',
                'meta_description' => 'Buy glass and surface cleaners online',
            ],
            
            // Sub-categories under Laundry Care (parent_id = 5)
            [
                'id' => 12,
                'name_en' => 'Fabric Care',
                'name_ta' => 'துணி பராமரிப்பு',
                'slug' => 'fabric-care',
                'description_en' => 'Fabric conditioners, whiteners, and laundry additives.',
                'description_ta' => 'ஃபேப்ரிக் கண்டிஷனர்கள், வைட்னர்கள்.',
                'parent_id' => 5,
                'is_active' => true,
                'sort_order' => 1,
                'is_featured' => false,
                'meta_title' => 'Fabric Care Products - Naturecare',
                'meta_description' => 'Buy fabric care products online',
            ],
            
            // Sub-categories under Personal Care (parent_id = 3)
            [
                'id' => 13,
                'name_en' => 'Hand Care',
                'name_ta' => 'கை பராமரிப்பு',
                'slug' => 'hand-care',
                'description_en' => 'Hand wash and hand sanitizers for daily hygiene.',
                'description_ta' => 'தினசரி சுகாதாரத்திற்கான கை கழுவும் நீர்மம்.',
                'parent_id' => 3,
                'is_active' => true,
                'sort_order' => 1,
                'is_featured' => true,
                'meta_title' => 'Hand Care Products - Naturecare',
                'meta_description' => 'Buy hand wash and sanitizer online',
            ],
            [
                'id' => 14,
                'name_en' => 'Feminine Hygiene',
                'name_ta' => 'பெண்கள் சுகாதாரம்',
                'slug' => 'feminine-hygiene',
                'description_en' => 'Safe and hygienic sanitary pads.',
                'description_ta' => 'பாதுகாப்பான மற்றும் சுகாதாரமான சானிட்டரி பேடுகள்.',
                'parent_id' => 3,
                'is_active' => true,
                'sort_order' => 2,
                'is_featured' => true,
                'meta_title' => 'Feminine Hygiene Products - Naturecare',
                'meta_description' => 'Buy sanitary pads online at best price',
            ],
            
            // Sub-category under Cleaning Products
            [
                'id' => 15,
                'name_en' => 'Pool & Specialty Cleaners',
                'name_ta' => 'குளம் மற்றும் சிறப்பு சுத்தப்படுத்திகள்',
                'slug' => 'pool-specialty-cleaners',
                'description_en' => 'Swimming pool cleaners and specialty cleaning products.',
                'description_ta' => 'நீச்சல் குளம் சுத்தப்படுத்திகள்.',
                'parent_id' => 2,
                'is_active' => true,
                'sort_order' => 6,
                'is_featured' => false,
                'meta_title' => 'Pool & Specialty Cleaners - Naturecare',
                'meta_description' => 'Buy pool cleaners and specialty products online',
            ],
        ];
    }
    
    /**
     * Default products data (fallback if CSV not found)
     */
    private function getDefaultProductsData(): array
    {
        return [
            // Floor Cleaners (category_id = 7)
            [
                'name_en' => 'Ultra Clean Floor Cleaner - Lemon Fragrance',
                'name_ta' => 'அல்ட்ரா கிளீன் ஃப்ளோர் க்ளீனர் - எலுமிச்சை வாசனை',
                'slug' => 'ultra-clean-floor-cleaner-lemon',
                'description_en' => 'Naturecare Ultra Clean Floor Cleaner with Lemon Fragrance. Advanced formula that removes tough stains and provides sparkling shine.',
                'description_ta' => 'நேச்சர்கேர் அல்ட்ரா கிளீன் ஃப்ளோர் க்ளீனர் எலுமிச்சை வாசனையுடன்.',
                'short_description_en' => 'Advanced floor cleaner with lemon fragrance - 5L',
                'short_description_ta' => 'மேம்பட்ட தரை சுத்தப்படுத்தி எலுமிச்சை வாசனை - 5L',
                'sku' => 'NC-FC-LEM-001',
                'price' => 450,
                'sale_price' => 399,
                'stock' => 100,
                'weight' => 5,
                'unit' => 'L',
                'category_id' => 7,
                'is_active' => true,
                'is_featured' => true,
                'is_bestseller' => false,
                'tax_rate' => 18,
                'nutritional_info_en' => 'Not applicable - Cleaning product',
                'nutritional_info_ta' => 'பொருந்தாது - சுத்தப்படுத்தும் பொருள்',
                'meta_title' => 'Ultra Clean Floor Cleaner Lemon 5L - Naturecare',
                'meta_description' => 'Buy Naturecare Ultra Clean Floor Cleaner Lemon fragrance 5L at best price',
                'sort_order' => 1,
            ],
            [
                'name_en' => 'Ultra Clean Floor Cleaner - Jasmine Fragrance',
                'name_ta' => 'அல்ட்ரா கிளீன் ஃப்ளோர் க்ளீனர் - மல்லிகை வாசனை',
                'slug' => 'ultra-clean-floor-cleaner-jasmine',
                'description_en' => 'Naturecare Ultra Clean Floor Cleaner with Jasmine Fragrance. Advanced formula that removes tough stains.',
                'description_ta' => 'நேச்சர்கேர் அல்ட்ரா கிளீன் ஃப்ளோர் க்ளீனர் மல்லிகை வாசனையுடன்.',
                'short_description_en' => 'Advanced floor cleaner with jasmine fragrance - 5L',
                'short_description_ta' => 'மேம்பட்ட தரை சுத்தப்படுத்தி மல்லிகை வாசனை - 5L',
                'sku' => 'NC-FC-JAS-003',
                'price' => 450,
                'sale_price' => 399,
                'stock' => 100,
                'weight' => 5,
                'unit' => 'L',
                'category_id' => 7,
                'is_active' => true,
                'is_featured' => true,
                'is_bestseller' => false,
                'tax_rate' => 18,
                'nutritional_info_en' => 'Not applicable - Cleaning product',
                'nutritional_info_ta' => 'பொருந்தாது - சுத்தப்படுத்தும் பொருள்',
                'meta_title' => 'Ultra Clean Floor Cleaner Jasmine 5L - Naturecare',
                'meta_description' => 'Buy Naturecare Ultra Clean Floor Cleaner Jasmine fragrance 5L at best price',
                'sort_order' => 2,
            ],
            
            // Phenyl & Disinfectants (category_id = 8)
            [
                'name_en' => 'Phenyl - Fresh Natural Fragrance Black',
                'name_ta' => 'ஃபீனைல் - புதிய இயற்கை வாசனை கருப்பு',
                'slug' => 'phenyl-fresh-natural-fragrance-black',
                'description_en' => 'Naturecare Phenyl with Fresh Natural Fragrance in Black variant. Powerful disinfectant and floor cleaner.',
                'description_ta' => 'நேச்சர்கேர் ஃபீனைல் புதிய இயற்கை வாசனை கருப்பு வகையில்.',
                'short_description_en' => 'Powerful phenyl disinfectant black - 5L',
                'short_description_ta' => 'சக்திவாய்ந்த ஃபீனைல் கிருமிநாசினி கருப்பு - 5L',
                'sku' => 'NC-PH-BLK-002',
                'price' => 400,
                'sale_price' => 349,
                'stock' => 100,
                'weight' => 5,
                'unit' => 'L',
                'category_id' => 8,
                'is_active' => true,
                'is_featured' => false,
                'is_bestseller' => true,
                'tax_rate' => 18,
                'nutritional_info_en' => 'Not applicable - Cleaning product',
                'nutritional_info_ta' => 'பொருந்தாது - சுத்தப்படுத்தும் பொருள்',
                'meta_title' => 'Phenyl Black Fresh Natural Fragrance 5L - Naturecare',
                'meta_description' => 'Buy Naturecare Phenyl Black Fresh Natural Fragrance 5L online',
                'sort_order' => 3,
            ],
            
            // Toilet Cleaners (category_id = 9)
            [
                'name_en' => 'Power Clean Toilet Cleaner',
                'name_ta' => 'பவர் கிளீன் டாய்லெட் க்ளீனர்',
                'slug' => 'power-clean-toilet-cleaner',
                'description_en' => 'Naturecare Power Clean Toilet Cleaner. Kills 99.9% germs and bacteria. Removes tough stains and scale.',
                'description_ta' => 'நேச்சர்கேர் பவர் கிளீன் டாய்லெட் க்ளீனர். 99.9% கிருமிகளை கொல்கிறது.',
                'short_description_en' => 'Powerful toilet cleaner - kills 99.9% germs',
                'short_description_ta' => 'சக்திவாய்ந்த டாய்லெட் க்ளீனர் - 99.9% கிருமிகளை கொல்கிறது',
                'sku' => 'NC-TC-PWR-021',
                'price' => 380,
                'sale_price' => 329,
                'stock' => 100,
                'weight' => 5,
                'unit' => 'L',
                'category_id' => 9,
                'is_active' => true,
                'is_featured' => true,
                'is_bestseller' => true,
                'tax_rate' => 18,
                'nutritional_info_en' => 'Not applicable - Cleaning product',
                'nutritional_info_ta' => 'பொருந்தாது - சுத்தப்படுத்தும் பொருள்',
                'meta_title' => 'Power Clean Toilet Cleaner 5L - Naturecare',
                'meta_description' => 'Buy Naturecare Power Clean Toilet Cleaner 5L online',
                'sort_order' => 4,
            ],
            
            // Hand Care (category_id = 13)
            [
                'name_en' => 'Hand Sanitizer',
                'name_ta' => 'கை சுத்தப்படுத்தி',
                'slug' => 'hand-sanitizer',
                'description_en' => 'Naturecare Hand Sanitizer. Kills 99.9% germs effectively. No water required. Quick dry formula.',
                'description_ta' => 'நேச்சர்கேர் கை சுத்தப்படுத்தி. 99.9% கிருமிகளை திறம்பட கொல்கிறது.',
                'short_description_en' => 'Hand sanitizer kills 99.9% germs - 5L',
                'short_description_ta' => '99.9% கிருமிகளை கொல்லும் கை சுத்தப்படுத்தி - 5L',
                'sku' => 'NC-HS-028',
                'price' => 400,
                'sale_price' => 349,
                'stock' => 100,
                'weight' => 5,
                'unit' => 'L',
                'category_id' => 13,
                'is_active' => true,
                'is_featured' => true,
                'is_bestseller' => true,
                'tax_rate' => 18,
                'nutritional_info_en' => 'Not applicable - Hygiene product',
                'nutritional_info_ta' => 'பொருந்தாது - சுகாதார பொருள்',
                'meta_title' => 'Hand Sanitizer 5L - Naturecare',
                'meta_description' => 'Buy Naturecare Hand Sanitizer 5L online',
                'sort_order' => 5,
            ],
            [
                'name_en' => 'Hand Wash',
                'name_ta' => 'கை கழுவும் நீர்மம்',
                'slug' => 'hand-wash',
                'description_en' => 'Naturecare Hand Wash. Removes dirt and germs effectively. Soft and gentle on skin.',
                'description_ta' => 'நேச்சர்கேர் கை கழுவும் நீர்மம். அழுக்கு மற்றும் கிருமிகளை திறம்பட நீக்குகிறது.',
                'short_description_en' => 'Hand wash for daily hygiene - 5L',
                'short_description_ta' => 'தினசரி சுகாதாரத்திற்கு கை கழுவும் நீர்மம் - 5L',
                'sku' => 'NC-HW-030',
                'price' => 350,
                'sale_price' => 299,
                'stock' => 100,
                'weight' => 5,
                'unit' => 'L',
                'category_id' => 13,
                'is_active' => true,
                'is_featured' => false,
                'is_bestseller' => false,
                'tax_rate' => 18,
                'nutritional_info_en' => 'Not applicable - Hygiene product',
                'nutritional_info_ta' => 'பொருந்தாது - சுகாதார பொருள்',
                'meta_title' => 'Hand Wash 5L - Naturecare',
                'meta_description' => 'Buy Naturecare Hand Wash 5L online',
                'sort_order' => 6,
            ],
            
            // Feminine Hygiene (category_id = 14)
            [
                'name_en' => 'Naturecare Sanitary Pads - Regular (12 Pads)',
                'name_ta' => 'நேச்சர்கேர் சானிட்டரி பேடுகள் - ரெகுலர் (12 பேடுகள்)',
                'slug' => 'naturecare-sanitary-pads-regular',
                'description_en' => 'Naturecare Sanitary Pads with 5-in-1 feature. Dioxin free, 100% safe and hygiene. Ultra soft and cotton layer.',
                'description_ta' => 'நேச்சர்கேர் சானிட்டரி பேடுகள் 5-இன்-1 அம்சத்துடன். டையாக்சின் இலவசம்.',
                'short_description_en' => 'Dioxin free sanitary pads - 12 pads',
                'short_description_ta' => 'டையாக்சின் இலவச சானிட்டரி பேடுகள் - 12 பேடுகள்',
                'sku' => 'NC-SP-REG-001',
                'price' => 120,
                'sale_price' => 99,
                'stock' => 200,
                'weight' => 12,
                'unit' => 'pieces',
                'category_id' => 14,
                'is_active' => true,
                'is_featured' => true,
                'is_bestseller' => true,
                'tax_rate' => 12,
                'nutritional_info_en' => 'Not applicable - Hygiene product',
                'nutritional_info_ta' => 'பொருந்தாது - சுகாதார பொருள்',
                'meta_title' => 'Naturecare Sanitary Pads Regular 12 Pads',
                'meta_description' => 'Buy Naturecare Sanitary Pads Regular 12 Pads online',
                'sort_order' => 7,
            ],
            
            // Hair Care (category_id = 4)
            [
                'name_en' => 'Herbal Shampoo - 200ml',
                'name_ta' => 'ஹர்பல் ஷாம்பு - 200ml',
                'slug' => 'herbal-shampoo-200ml',
                'description_en' => 'Naturecare Herbal Shampoo with 2X result. Sulfate free, paraben free, PEG free.',
                'description_ta' => 'நேச்சர்கேர் ஹர்பல் ஷாம்பு 2X முடிவுடன். சல்ஃபேட் இலவசம்.',
                'short_description_en' => 'Chemical-free herbal shampoo - 200ml',
                'short_description_ta' => 'ரசாயனம் இல்லாத ஹர்பல் ஷாம்பு - 200ml',
                'sku' => 'NC-HS-200',
                'price' => 150,
                'sale_price' => 125,
                'stock' => 200,
                'weight' => 200,
                'unit' => 'ml',
                'category_id' => 4,
                'is_active' => true,
                'is_featured' => true,
                'is_bestseller' => true,
                'tax_rate' => 18,
                'nutritional_info_en' => 'Not applicable - Personal care product',
                'nutritional_info_ta' => 'பொருந்தாது - தனிப்பட்ட பராமரிப்பு பொருள்',
                'meta_title' => 'Herbal Shampoo 200ml - Naturecare',
                'meta_description' => 'Buy Naturecare Herbal Shampoo 200ml sulfate free online',
                'sort_order' => 8,
            ],
            
            // Laundry Care - Fabric Care (category_id = 12)
            [
                'name_en' => 'Pure Wash Detergent Liquid - Fresh Natural Fragrance',
                'name_ta' => 'பியூர் வாஷ் டிடர்ஜெண்ட் லிக்விட் - புதிய இயற்கை வாசனை',
                'slug' => 'pure-wash-detergent-liquid-fresh-natural-fragrance',
                'description_en' => 'Naturecare Pure Wash Detergent Liquid with Fresh Natural Fragrance. Suitable for both front load and top load washing machines.',
                'description_ta' => 'நேச்சர்கேர் பியூர் வாஷ் டிடர்ஜெண்ட் லிக்விட் புதிய இயற்கை வாசனையுடன்.',
                'short_description_en' => 'Detergent liquid for front & top load - 5L',
                'short_description_ta' => 'ஃப்ரண்ட் & டாப் லோடுக்கு டிடர்ஜெண்ட் லிக்விட் - 5L',
                'sku' => 'NC-DL-PW-026',
                'price' => 450,
                'sale_price' => 399,
                'stock' => 100,
                'weight' => 5,
                'unit' => 'L',
                'category_id' => 12,
                'is_active' => true,
                'is_featured' => true,
                'is_bestseller' => true,
                'tax_rate' => 18,
                'nutritional_info_en' => 'Not applicable - Cleaning product',
                'nutritional_info_ta' => 'பொருந்தாது - சுத்தப்படுத்தும் பொருள்',
                'meta_title' => 'Pure Wash Detergent Liquid 5L - Naturecare',
                'meta_description' => 'Buy Naturecare Pure Wash Detergent Liquid 5L online',
                'sort_order' => 9,
            ],
            
            // Dish Washing (category_id = 10)
            [
                'name_en' => 'Clean Wash Dish Washing Gel',
                'name_ta' => 'க்ளீன் வாஷ் டிஷ் வாஷிங் ஜெல்',
                'slug' => 'clean-wash-dish-washing-gel',
                'description_en' => 'Naturecare Clean Wash Dish Washing Gel. Removes tough oil and grease easily. Gives sparkling clean utensils.',
                'description_ta' => 'நேச்சர்கேர் க்ளீன் வாஷ் டிஷ் வாஷிங் ஜெல். கடினமான எண்ணெய் மற்றும் கிரீஸை எளிதாக நீக்குகிறது.',
                'short_description_en' => 'Dish washing gel with lemon - 5L',
                'short_description_ta' => 'எலுமிச்சையுடன் டிஷ் வாஷிங் ஜெல் - 5L',
                'sku' => 'NC-DW-CW-027',
                'price' => 350,
                'sale_price' => 299,
                'stock' => 100,
                'weight' => 5,
                'unit' => 'L',
                'category_id' => 10,
                'is_active' => true,
                'is_featured' => false,
                'is_bestseller' => false,
                'tax_rate' => 18,
                'nutritional_info_en' => 'Not applicable - Cleaning product',
                'nutritional_info_ta' => 'பொருந்தாது - சுத்தப்படுத்தும் பொருள்',
                'meta_title' => 'Clean Wash Dish Washing Gel 5L - Naturecare',
                'meta_description' => 'Buy Naturecare Clean Wash Dish Washing Gel 5L online',
                'sort_order' => 10,
            ],
            
            // Glass & Surface Cleaners (category_id = 11)
            [
                'name_en' => 'Glass Cleaner - Fresh Natural Fragrance',
                'name_ta' => 'கண்ணாடி சுத்தப்படுத்தி - புதிய இயற்கை வாசனை',
                'slug' => 'glass-cleaner-fresh-natural-fragrance',
                'description_en' => 'Naturecare Glass Cleaner with Fresh Natural Fragrance. Provides streak-free shine.',
                'description_ta' => 'நேச்சர்கேர் கண்ணாடி சுத்தப்படுத்தி புதிய இயற்கை வாசனையுடன்.',
                'short_description_en' => 'Streak-free glass cleaner - 5L',
                'short_description_ta' => 'பட்டை இல்லாத கண்ணாடி சுத்தப்படுத்தி - 5L',
                'sku' => 'NC-GC-023',
                'price' => 320,
                'sale_price' => 279,
                'stock' => 100,
                'weight' => 5,
                'unit' => 'L',
                'category_id' => 11,
                'is_active' => true,
                'is_featured' => false,
                'is_bestseller' => false,
                'tax_rate' => 18,
                'nutritional_info_en' => 'Not applicable - Cleaning product',
                'nutritional_info_ta' => 'பொருந்தாது - சுத்தப்படுத்தும் பொருள்',
                'meta_title' => 'Glass Cleaner Fresh Natural 5L - Naturecare',
                'meta_description' => 'Buy Naturecare Glass Cleaner Fresh Natural Fragrance 5L online',
                'sort_order' => 11,
            ],
            
            // Air Fresheners (category_id = 6)
            [
                'name_en' => 'Room Freshener - Green Apple Fragrance',
                'name_ta' => 'அறை புதுப்பிப்பான் - பச்சை ஆப்பிள் வாசனை',
                'slug' => 'room-freshener-green-apple-fragrance',
                'description_en' => 'Naturecare Room Freshener with Green Apple Fragrance. Safe for daily use. Refreshes air instantly.',
                'description_ta' => 'நேச்சர்கேர் அறை புதுப்பிப்பான் பச்சை ஆப்பிள் வாசனையுடன்.',
                'short_description_en' => 'Room freshener green apple - 5L',
                'short_description_ta' => 'அறை புதுப்பிப்பான் பச்சை ஆப்பிள் - 5L',
                'sku' => 'NC-RF-GA-010',
                'price' => 350,
                'sale_price' => 299,
                'stock' => 100,
                'weight' => 5,
                'unit' => 'L',
                'category_id' => 6,
                'is_active' => true,
                'is_featured' => false,
                'is_bestseller' => false,
                'tax_rate' => 18,
                'nutritional_info_en' => 'Not applicable - Air freshener',
                'nutritional_info_ta' => 'பொருந்தாது - காற்று புதுப்பிப்பான்',
                'meta_title' => 'Room Freshener Green Apple 5L - Naturecare',
                'meta_description' => 'Buy Naturecare Room Freshener Green Apple Fragrance 5L online',
                'sort_order' => 12,
            ],
        ];
    }
}
