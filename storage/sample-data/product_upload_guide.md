# Product Bulk Upload Guide

## Excel/CSV Format for Product Import

The template file is located at: `storage/sample-data/product_bulk_upload_template.csv`

You can open this CSV file directly in Excel, Google Sheets, or any spreadsheet application.

### Database Fields

| Column Name | Required | Data Type | Description | Example |
|-------------|----------|-----------|-------------|---------|
| name_en | Yes | String | Product name in English | "Organic Turmeric Powder" |
| name_ta | No | String | Product name in Tamil | "மஞ்சள் தூள்" |
| slug | No | String | URL-friendly slug (auto-generated if empty) | "organic-turmeric-powder" |
| description_en | No | Text | Full description in English | "Premium organic turmeric..." |
| description_ta | No | Text | Full description in Tamil | "தமிழ்நாட்டில் உள்ள..." |
| short_description_en | No | Text | Short description in English | "100% organic turmeric..." |
| short_description_ta | No | Text | Short description in Tamil | "100% இயற்கை மஞ்சள்..." |
| sku | No | String | Stock keeping unit | "TUR-001" |
| price | Yes | Decimal | Regular price in INR | 250 |
| sale_price | No | Decimal | Sale/discount price in INR | 199 |
| stock | No | Integer | Stock quantity | 50 |
| weight | No | String | Weight value | "500" |
| unit | No | String | Unit: piece, kg, gm, ltr, ml | "gm" |
| category_id | No | Integer | Category ID from categories table | 1 |
| is_active | No | Boolean | Product active status (true/false) | true |
| is_featured | No | Boolean | Featured product (true/false) | true |
| is_bestseller | No | Boolean | Bestseller product (true/false) | true |
| tax_rate | No | Decimal | GST tax rate percentage | 5 |
| nutritional_info_en | No | Text | Nutritional info in English | "Energy: 354kcal..." |
| nutritional_info_ta | No | Text | Nutritional info in Tamil | "ஆற்றல்: 354கி..." |
| meta_title | No | String | SEO meta title | "Organic Turmeric Powder" |
| meta_description | No | Text | SEO meta description | "Premium organic turmeric..." |
| sort_order | No | Integer | Display order | 1 |

### How to Use

1. **Open in Excel**: Double-click the CSV file to open it in Excel, or import it as a CSV in Google Sheets.

2. **Edit Data**: Fill in your product data following the column headers. 
   - Required fields: `name_en`, `price`
   - For boolean fields (is_active, is_featured, is_bestseller), use: `true`, `false`, `1`, `0`, `yes`, `no`
   - For category_id, first check the categories table to get valid category IDs

3. **Save**: Save the file as CSV (Comma Separated Values) format

4. **Import to Database**: Run the Laravel command:
   ```bash
   php artisan products:import
   ```

5. **Dry Run** (optional): Test the import without actually importing:
   ```bash
   php artisan products:import --dry-run
   ```

### Import Command Options

```bash
# Import from default location
php artisan products:import

# Import from custom file path
php artisan products:import /path/to/your/file.csv

# Dry run - validate without importing
php artisan products:import --dry-run
```

### Sample Data

The template includes 3 sample products:
1. Organic Turmeric Powder (TUR-001)
2. Premium Cardamom (ELC-002)
3. Traditional Sambar Powder (SMB-003)

### Notes

- If `slug` is not provided, it will be auto-generated from `name_en`
- If `category_id` is invalid or empty, the product will be imported without a category
- If `sku` is empty, products can be created without SKU
- Duplicate slugs will be auto-appended with a timestamp
- Boolean values are case-insensitive (true, True, TRUE, 1, yes all work)
