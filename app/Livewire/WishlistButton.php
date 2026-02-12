<?php

namespace App\Livewire;

use App\Models\Wishlist;
use Livewire\Component;

class WishlistButton extends Component
{
    public int $productId;

    public bool $isWishlisted = false;

    public string $size = 'sm';

    public function mount(int $productId, string $size = 'sm'): void
    {
        $this->productId = $productId;
        $this->size = $size;

        if (auth()->check()) {
            $this->isWishlisted = Wishlist::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->exists();
        }
    }

    public function toggle(): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'), navigate: false);

            return;
        }

        if ($this->isWishlisted) {
            Wishlist::where('user_id', auth()->id())
                ->where('product_id', $this->productId)
                ->delete();
            $this->isWishlisted = false;
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $this->productId,
            ]);
            $this->isWishlisted = true;
        }

        $this->dispatch('wishlist-updated');
    }

    public function render()
    {
        return view('livewire.wishlist-button');
    }
}
