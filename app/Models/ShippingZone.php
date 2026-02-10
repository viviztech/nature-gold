<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = [
        'name',
        'districts',
        'base_rate',
        'per_kg_rate',
        'free_above',
        'estimated_days',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'districts' => 'array',
            'base_rate' => 'decimal:2',
            'per_kg_rate' => 'decimal:2',
            'free_above' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public static function findByDistrict(string $district): ?self
    {
        return static::where('is_active', true)
            ->get()
            ->first(function ($zone) use ($district) {
                return in_array($district, $zone->districts ?? []);
            });
    }

    public function calculateShipping(float $orderTotal, float $totalWeight = 0): float
    {
        if ($this->free_above && $orderTotal >= $this->free_above) {
            return 0;
        }

        $cost = $this->base_rate;

        if ($this->per_kg_rate > 0 && $totalWeight > 0) {
            $cost += ($this->per_kg_rate * $totalWeight);
        }

        return round($cost, 2);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
