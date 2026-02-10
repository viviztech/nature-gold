<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title_en',
        'title_ta',
        'slug',
        'content_en',
        'content_ta',
        'meta_title',
        'meta_description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return $locale === 'ta' && $this->title_ta ? $this->title_ta : $this->title_en;
    }

    public function getContentAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'ta' && $this->content_ta ? $this->content_ta : $this->content_en;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
