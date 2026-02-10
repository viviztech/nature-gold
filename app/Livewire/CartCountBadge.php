<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Attributes\On;
use Livewire\Component;

class CartCountBadge extends Component
{
    public int $count = 0;

    public function mount(): void
    {
        $this->updateCount();
    }

    #[On('cart-updated')]
    public function updateCount(): void
    {
        $cart = Cart::currentCart();
        $this->count = $cart ? $cart->item_count : 0;
    }

    public function render()
    {
        return <<<'BLADE'
        @if($count > 0)
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-gold-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                {{ $count > 99 ? '99+' : $count }}
            </span>
        @endif
        BLADE;
    }
}
