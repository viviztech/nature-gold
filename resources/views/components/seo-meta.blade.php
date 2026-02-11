{{-- SEO Meta Tags --}}
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $canonical }}">

{{-- Open Graph --}}
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $url }}">
@if($image)
    <meta property="og:image" content="{{ $image }}">
@endif
<meta property="og:site_name" content="{{ config('app.name', 'Nature Gold') }}">
<meta property="og:locale" content="{{ app()->getLocale() === 'ta' ? 'ta_IN' : 'en_IN' }}">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
@if($image)
    <meta name="twitter:image" content="{{ $image }}">
@endif

{{-- Alternate Language --}}
@if(app()->getLocale() === 'en')
    <link rel="alternate" hreflang="ta" href="{{ url('/ta' . request()->getPathInfo()) }}">
    <link rel="alternate" hreflang="en" href="{{ url(request()->getPathInfo()) }}">
@else
    <link rel="alternate" hreflang="en" href="{{ url(str_replace('/ta/', '/', request()->getPathInfo())) }}">
    <link rel="alternate" hreflang="ta" href="{{ url(request()->getPathInfo()) }}">
@endif
<link rel="alternate" hreflang="x-default" href="{{ url(request()->getPathInfo()) }}">

{{-- JSON-LD Structured Data --}}
@if($jsonLd)
    <script type="application/ld+json">
        {!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endif
