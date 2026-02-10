<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Attributes\On;
use Livewire\Component;

class CartIcon extends Component
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
        return view('livewire.cart-icon');
    }
}
