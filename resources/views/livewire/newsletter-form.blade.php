<div>
    @if($subscribed)
        <p class="text-gold-100 font-medium">{{ __('shop.newsletter_success') }}</p>
    @else
        <form wire:submit="subscribe" class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            <input type="email"
                   wire:model="email"
                   placeholder="{{ __('shop.newsletter_placeholder') }}"
                   class="px-4 py-2.5 rounded-lg text-gray-800 text-sm w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-gold-300"
                   required>
            <button type="submit" class="px-5 py-2.5 bg-nature-700 text-white text-sm font-medium rounded-lg hover:bg-nature-800 transition whitespace-nowrap">
                {{ __('shop.subscribe') }}
            </button>
        </form>
        @error('email') <p class="text-red-200 text-xs mt-1">{{ $message }}</p> @enderror
    @endif
</div>
