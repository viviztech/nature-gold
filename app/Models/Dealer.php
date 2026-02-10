<?php

namespace App\Models;

use App\Enums\DealerStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dealer extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'gst_number',
        'business_type',
        'territory',
        'business_address',
        'trade_license',
        'gst_certificate',
        'commission_rate',
        'status',
        'approved_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'status' => DealerStatus::class,
            'commission_rate' => 'decimal:2',
            'approved_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function specialPricing(): HasMany
    {
        return $this->hasMany(DealerPricing::class);
    }

    public function isApproved(): bool
    {
        return $this->status === DealerStatus::Approved;
    }

    public function isPending(): bool
    {
        return $this->status === DealerStatus::Pending;
    }

    public function scopeApproved($query)
    {
        return $query->where('status', DealerStatus::Approved);
    }

    public function scopePending($query)
    {
        return $query->where('status', DealerStatus::Pending);
    }
}
