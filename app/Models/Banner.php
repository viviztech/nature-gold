<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title_en',
        'title_ta',
        'subtitle_en',
        'subtitle_ta',
        'image',
        'mobile_image',
        'link',
        'button_text_en',
        'button_text_ta',
        'position',
        'sort_order',
        'is_active',
        'starts_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function getTitleAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'ta' && $this->title_ta ? $this->title_ta : $this->title_en;
    }

    public function getSubtitleAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'ta' && $this->subtitle_ta ? $this->subtitle_ta : $this->subtitle_en;
    }

    public function getButtonTextAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'ta' && $this->button_text_ta ? $this->button_text_ta : $this->button_text_en;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            });
    }

    public function scopeHero($query)
    {
        return $query->where('position', 'hero');
    }
}
