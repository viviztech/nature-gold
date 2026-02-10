<div class="flex items-center gap-1 text-sm">
    <button wire:click="switchLocale('en')"
            class="px-2 py-1 rounded {{ $locale === 'en' ? 'bg-gold-500 text-white font-semibold' : 'text-gray-600 hover:text-gold-600' }}">
        EN
    </button>
    <span class="text-gray-300">|</span>
    <button wire:click="switchLocale('ta')"
            class="px-2 py-1 rounded {{ $locale === 'ta' ? 'bg-gold-500 text-white font-semibold' : 'text-gray-600 hover:text-gold-600' }}"
            style="font-family: var(--font-tamil)">
        தமிழ்
    </button>
</div>
