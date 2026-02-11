<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SeoMeta extends Component
{
    public function __construct(
        public string $title = '',
        public string $description = '',
        public string $type = 'website',
        public ?string $image = null,
        public ?string $url = null,
        public ?string $canonical = null,
        public ?array $jsonLd = null,
    ) {
        $this->title = $title ?: config('app.name', 'Nature Gold');
        $this->description = $description ?: __('shop.seo_home_description');
        $this->url = $url ?: request()->url();
        $this->canonical = $canonical ?: $this->url;
    }

    public function render()
    {
        return view('components.seo-meta');
    }
}
