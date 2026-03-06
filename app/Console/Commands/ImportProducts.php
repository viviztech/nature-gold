<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportProducts extends Command
{
    protected $signature = 'products:import {file? : Path to CSV file} {--dry-run : Run without actually importing}';

    protected $description = 'Import products from CSV file';

    public function handle(): int
    {
        $file = $this->argument('file') ?? storage_path('sample-data/product_bulk_upload_template.csv');

        if (!file_exists($file)) {
            $this->error("File not found: {$file}");
            return Command::FAILURE;
        }

        $this->info("Reading CSV file: {$file}");

        try {
            $records = $this->readCsvFile($file);
            
            $this->info("Found " . count($records) . " records to import.");

            if ($this->option('dry-run')) {
                $this->warn("DRY RUN - No data will be imported.");
            }

            $bar = $this->output->createProgressBar(count($records));
            $bar->start();

            $imported = 0;
            $skipped = 0;
            $errors = [];

            foreach ($records as $record) {
                try {
                    // Validate required fields
                    if (empty($record['name_en']) || empty($record['price'])) {
                        $errors[] = "Missing required fields (name_en or price) for SKU: " . ($record['sku'] ?? 'unknown');
                        $skipped++;
                        $bar->advance();
                        continue;
                    }

                    // Check if category exists
                    $categoryId = null;
                    if (!empty($record['category_id'])) {
                        $category = Category::find($record['category_id']);
                        if (!$category) {
                            $errors[] = "Category ID {$record['category_id']} not found for product: {$record['name_en']}";
                            $skipped++;
                            $bar->advance();
                            continue;
                        }
                        $categoryId = $category->id;
                    }

                    // Generate slug if not provided
                    $slug = $record['slug'] ?? Str::slug($record['name_en']);

                    // Check if product with same slug exists
                    $existingProduct = Product::where('slug', $slug)->first();
                    if ($existingProduct) {
                        $slug = $slug . '-' . time();
                    }

                    if (!$this->option('dry-run')) {
                        $product = Product::create([
                            'name_en' => $record['name_en'],
                            'name_ta' => $record['name_ta'] ?? null,
                            'slug' => $slug,
                            'description_en' => $record['description_en'] ?? null,
                            'description_ta' => $record['description_ta'] ?? null,
                            'short_description_en' => $record['short_description_en'] ?? null,
                            'short_description_ta' => $record['short_description_ta'] ?? null,
                            'sku' => $record['sku'] ?? null,
                            'price' => (float) $record['price'],
                            'sale_price' => !empty($record['sale_price']) ? (float) $record['sale_price'] : null,
                            'stock' => (int) ($record['stock'] ?? 0),
                            'weight' => $record['weight'] ?? null,
                            'unit' => $record['unit'] ?? 'piece',
                            'category_id' => $categoryId,
                            'is_active' => $this->parseBoolean($record['is_active'] ?? 'true'),
                            'is_featured' => $this->parseBoolean($record['is_featured'] ?? 'false'),
                            'is_bestseller' => $this->parseBoolean($record['is_bestseller'] ?? 'false'),
                            'tax_rate' => (float) ($record['tax_rate'] ?? 5),
                            'nutritional_info_en' => $record['nutritional_info_en'] ?? null,
                            'nutritional_info_ta' => $record['nutritional_info_ta'] ?? null,
                            'meta_title' => $record['meta_title'] ?? null,
                            'meta_description' => $record['meta_description'] ?? null,
                            'sort_order' => (int) ($record['sort_order'] ?? 0),
                        ]);

                        $this->line(" Imported: {$product->name_en}");
                    }

                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Error importing product: " . ($record['sku'] ?? $record['name_en'] ?? 'unknown') . " - " . $e->getMessage();
                    $skipped++;
                }

                $bar->advance();
            }

            $bar->finish();
            $this->newLine(2);

            $this->info("Import completed!");
            $this->info("Imported: {$imported} products");
            $this->info("Skipped: {$skipped} products");

            if (!empty($errors)) {
                $this->warn("\nErrors encountered:");
                foreach ($errors as $error) {
                    $this->line("  - {$error}");
                }
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Failed to import: " . $e->getMessage());
            return Command::FAILURE;
        }
    }

    private function readCsvFile(string $file): array
    {
        // First try the database seeders data folder
        $dbFile = database_path('seeders/data/' . basename($file));
        
        if (!file_exists($file) && file_exists($dbFile)) {
            $file = $dbFile;
        }
        
        // Also check storage/sample-data as fallback
        if (!file_exists($file)) {
            $storageFile = storage_path('sample-data/' . basename($file));
            if (file_exists($storageFile)) {
                $file = $storageFile;
            }
        }

        $handle = fopen($file, 'r');
        $headers = fgetcsv($handle);
        $records = [];

        while (($row = fgetcsv($handle)) !== false) {
            $records[] = array_combine($headers, $row);
        }

        fclose($handle);
        return $records;
    }

    private function parseBoolean($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }
        
        return in_array(strtolower(trim($value)), ['true', '1', 'yes', 'on']);
    }
}
