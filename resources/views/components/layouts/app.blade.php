<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Nature Gold') }} | {{ config('app.name', 'Nature Gold') }}</title>

    {{-- SEO Meta, OG Tags, Structured Data --}}
    <x-seo-meta
        :title="$title ?? config('app.name', 'Nature Gold')"
        :description="$metaDescription ?? __('shop.seo_home_description')"
        :type="$ogType ?? 'website'"
        :image="$ogImage ?? null"
        :json-ld="$jsonLd ?? null"
    />

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&family=Noto+Sans+Tamil:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>
<body class="bg-warm-white text-gray-800 font-sans antialiased">
    {{-- Announcement Bar --}}
    <x-announcement-bar />

    {{-- Header --}}
    <x-header />

    {{-- Main Content --}}
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <x-footer />

    {{-- Mobile Bottom Nav --}}
    <x-mobile-nav />

    {{-- WhatsApp Floating Button --}}
    <x-whatsapp-button />

    @livewireScripts
</body>
</html>
