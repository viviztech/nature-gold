<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name_en',
        'name_ta',
        'slug',
        'description_en',
        'description_ta',
        'short_description_en',
        'short_description_ta',
        'sku',
        'price',
        'sale_price',
        'stock',
        'weight',
        'unit',
        'category_id',
        'is_active',
        'is_featured',
        'is_bestseller',
        'tax_rate',
        'nutritional_info_en',
        'nutritional_info_ta',
        'meta_title',
        'meta_description',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'tax_rate' => 'decimal:2',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasMany
    {
        return $this->hasMany(ProductImage::class)->where('is_primary', true);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->orderBy('sort_order');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();
        return $locale === 'ta' && $this->name_ta ? $this->name_ta : $this->name_en;
    }

    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'ta' && $this->description_ta ? $this->description_ta : $this->description_en;
    }

    public function getShortDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'ta' && $this->short_description_ta ? $this->short_description_ta : $this->short_description_en;
    }

    public function getEffectivePriceAttribute(): string
    {
        return $this->sale_price && $this->sale_price < $this->price
            ? $this->sale_price
            : $this->price;
    }

    public function getDiscountPercentageAttribute(): int
    {
        if (! $this->sale_price || $this->sale_price >= $this->price) {
            return 0;
        }

        return (int) round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    public function getIsInStockAttribute(): bool
    {
        if ($this->variants()->exists()) {
            return $this->variants()->where('stock', '>', 0)->exists();
        }

        return $this->stock > 0;
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->approvedReviews()->avg('rating') ?? 0, 1);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeBestseller($query)
    {
        return $query->where('is_bestseller', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
