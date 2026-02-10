<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Livewire\Component;

class AddToCartButton extends Component
{
    public Product $product;

    public ?int $variantId = null;

    public int $quantity = 1;

    public bool $added = false;

    public function mount(Product $product): void
    {
        $this->product = $product;
        $defaultVariant = $product->variants->first();
        $this->variantId = $defaultVariant?->id;
    }

    public function addToCart(): void
    {
        $cart = Cart::currentCart(create: true);

        $existing = $cart->items()
            ->where('product_id', $this->product->id)
            ->where('variant_id', $this->variantId)
            ->first();

        if ($existing) {
            $existing->increment('quantity', $this->quantity);
        } else {
            $cart->items()->create([
                'product_id' => $this->product->id,
                'variant_id' => $this->variantId,
                'quantity' => $this->quantity,
            ]);
        }

        $this->added = true;
        $this->dispatch('cart-updated');

        // Reset after 2 seconds
        $this->js('setTimeout(() => $wire.set("added", false), 2000)');
    }

    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}
