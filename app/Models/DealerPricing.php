<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DealerPricing extends Model
{
    protected $table = 'dealer_pricing';

    protected $fillable = [
        'dealer_id',
        'product_id',
        'special_price',
        'min_quantity',
    ];

    protected function casts(): array
    {
        return [
            'special_price' => 'decimal:2',
        ];
    }

    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
