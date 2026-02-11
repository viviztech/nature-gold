<div x-data="{ messages: [
        '{{ __('shop.announcement_free_delivery') }}',
        '{{ __('shop.announcement_natural') }}',
        '{{ __('shop.announcement_farm') }}'
    ], current: 0 }"
    x-init="setInterval(() => current = (current + 1) % messages.length, 4000)"
    class="bg-nature-700 text-white text-center text-sm font-medium">
    <div class="relative h-9 flex items-center justify-center overflow-hidden">
        <template x-for="(msg, index) in messages" :key="index">
            <span x-show="current === index"
                  x-transition:enter="transition ease-out duration-500"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100"
                  x-transition:leave="transition ease-in duration-300"
                  x-transition:leave-start="opacity-100"
                  x-transition:leave-end="opacity-0"
                  class="absolute inset-0 flex items-center justify-center px-4"
                  x-text="msg">
            </span>
        </template>
    </div>
</div>
