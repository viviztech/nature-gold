<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPost extends Model
{
    protected $fillable = [
        'title_en',
        'title_ta',
        'slug',
        'excerpt_en',
        'excerpt_ta',
        'content_en',
        'content_ta',
        'featured_image',
        'author_id',
        'category',
        'tags',
        'meta_title',
        'meta_description',
        'is_published',
        'published_at',
        'reading_time',
        'views',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();

        return $locale === 'ta' && $this->title_ta ? $this->title_ta : $this->title_en;
    }

    public function getExcerptAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'ta' && $this->excerpt_ta ? $this->excerpt_ta : $this->excerpt_en;
    }

    public function getContentAttribute(): string
    {
        $locale = app()->getLocale();

        return $locale === 'ta' && $this->content_ta ? $this->content_ta : $this->content_en;
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
