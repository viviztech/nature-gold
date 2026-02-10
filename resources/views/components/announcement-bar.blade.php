<div x-data="{ messages: [
        '{{ __('shop.announcement_free_delivery') }}',
        '{{ __('shop.announcement_natural') }}',
        '{{ __('shop.announcement_farm') }}'
    ], current: 0 }"
    x-init="setInterval(() => current = (current + 1) % messages.length, 4000)"
    class="bg-nature-700 text-white text-center py-2 px-4 text-sm font-medium relative overflow-hidden">
    <template x-for="(msg, index) in messages" :key="index">
        <span x-show="current === index"
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 translate-y-4"
              x-transition:enter-end="opacity-100 translate-y-0"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100 translate-y-0"
              x-transition:leave-end="opacity-0 -translate-y-4"
              class="block"
              x-text="msg">
        </span>
    </template>
</div>
