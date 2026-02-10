<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Coupon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class CartPage extends Component
{
    public ?Cart $cart = null;

    public string $couponCode = '';

    public ?string $couponError = null;

    public ?string $couponSuccess = null;

    public function mount(): void
    {
        $this->loadCart();
    }

    public function loadCart(): void
    {
        $this->cart = Cart::currentCart();
    }

    public function incrementQuantity(int $itemId): void
    {
        $item = $this->cart?->items()->find($itemId);

        if ($item) {
            $item->increment('quantity');
            $this->refreshCart();
        }
    }

    public function decrementQuantity(int $itemId): void
    {
        $item = $this->cart?->items()->find($itemId);

        if ($item) {
            if ($item->quantity <= 1) {
                $this->removeItem($itemId);
                return;
            }

            $item->decrement('quantity');
            $this->refreshCart();
        }
    }

    public function removeItem(int $itemId): void
    {
        $this->cart?->items()->where('id', $itemId)->delete();
        $this->refreshCart();
    }

    public function applyCoupon(): void
    {
        $this->couponError = null;
        $this->couponSuccess = null;

        if (empty(trim($this->couponCode))) {
            $this->couponError = __('shop.coupon_enter_code');
            return;
        }

        $coupon = Coupon::where('code', strtoupper(trim($this->couponCode)))->first();

        if (! $coupon) {
            $this->couponError = __('shop.coupon_invalid');
            return;
        }

        if (! $coupon->isValid()) {
            $this->couponError = __('shop.coupon_expired');
            return;
        }

        if ($coupon->min_order && $this->getSubtotalProperty() < $coupon->min_order) {
            $this->couponError = __('shop.coupon_min_order', ['amount' => number_format($coupon->min_order, 0)]);
            return;
        }

        $this->cart->update(['coupon_code' => strtoupper(trim($this->couponCode))]);
        $this->couponSuccess = __('shop.coupon_applied');
        $this->refreshCart();
    }

    public function removeCoupon(): void
    {
        $this->cart->update(['coupon_code' => null]);
        $this->couponCode = '';
        $this->couponError = null;
        $this->couponSuccess = null;
        $this->refreshCart();
    }

    public function getSubtotalProperty(): float
    {
        return $this->cart?->subtotal ?? 0;
    }

    public function getDiscountProperty(): float
    {
        if (! $this->cart?->coupon_code) {
            return 0;
        }

        $coupon = Coupon::where('code', $this->cart->coupon_code)->first();

        if (! $coupon || ! $coupon->isValid()) {
            return 0;
        }

        return $coupon->calculateDiscount($this->getSubtotalProperty());
    }

    public function getShippingProperty(): float
    {
        $subtotal = $this->getSubtotalProperty();

        if ($subtotal <= 0) {
            return 0;
        }

        // Free shipping over 500
        return $subtotal >= 500 ? 0 : 50;
    }

    public function getTaxProperty(): float
    {
        $taxable = $this->getSubtotalProperty() - $this->getDiscountProperty();

        return round($taxable * 0.05, 2);
    }

    public function getTotalProperty(): float
    {
        return $this->getSubtotalProperty()
            - $this->getDiscountProperty()
            + $this->getShippingProperty()
            + $this->getTaxProperty();
    }

    protected function refreshCart(): void
    {
        $this->cart = Cart::currentCart();
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
