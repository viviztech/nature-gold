<?php

namespace App\Livewire;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.app')]
class CheckoutPage extends Component
{
    #[Validate('required|string|max:100')]
    public string $name = '';

    #[Validate('required_without:phone|nullable|email|max:150')]
    public string $email = '';

    #[Validate('required|string|regex:/^[6-9]\d{9}$/')]
    public string $phone = '';

    #[Validate('required|string|max:255')]
    public string $address_line1 = '';

    #[Validate('nullable|string|max:255')]
    public string $address_line2 = '';

    #[Validate('required|string|max:100')]
    public string $city = '';

    #[Validate('required|string|max:100')]
    public string $district = '';

    #[Validate('required|string|max:100')]
    public string $state = 'Tamil Nadu';

    #[Validate('required|string|regex:/^[1-9][0-9]{5}$/')]
    public string $pincode = '';

    #[Validate('required|string|in:razorpay,phonepe,cod')]
    public string $payment_method = 'razorpay';

    public ?Cart $cart = null;

    public function mount(): void
    {
        $this->cart = Cart::currentCart();

        if (! $this->cart || $this->cart->items->isEmpty()) {
            $this->redirect(route('cart'));
            return;
        }

        // Pre-fill from authenticated user
        if (auth()->check()) {
            $user = auth()->user();
            $this->name = $user->name ?? '';
            $this->email = $user->email ?? '';
            $this->phone = $user->phone ?? '';

            // Pre-fill from default address
            $defaultAddress = $user->defaultAddress;

            if ($defaultAddress) {
                $this->name = $defaultAddress->name ?: $this->name;
                $this->phone = $defaultAddress->phone ?: $this->phone;
                $this->address_line1 = $defaultAddress->line1 ?? '';
                $this->address_line2 = $defaultAddress->line2 ?? '';
                $this->city = $defaultAddress->city ?? '';
                $this->district = $defaultAddress->district ?? '';
                $this->state = $defaultAddress->state ?? 'Tamil Nadu';
                $this->pincode = $defaultAddress->pincode ?? '';
            }
        }
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

    public function placeOrder(): void
    {
        $this->validate();

        $this->cart = Cart::currentCart();

        if (! $this->cart || $this->cart->items->isEmpty()) {
            session()->flash('error', __('shop.cart_empty_title'));
            $this->redirect(route('cart'));
            return;
        }

        $shippingAddress = [
            'name' => $this->name,
            'phone' => $this->phone,
            'line1' => $this->address_line1,
            'line2' => $this->address_line2,
            'city' => $this->city,
            'district' => $this->district,
            'state' => $this->state,
            'pincode' => $this->pincode,
        ];

        $order = Order::create([
            'user_id' => auth()->id(),
            'subtotal' => $this->getSubtotalProperty(),
            'discount' => $this->getDiscountProperty(),
            'shipping_cost' => $this->getShippingProperty(),
            'tax' => $this->getTaxProperty(),
            'total' => $this->getTotalProperty(),
            'status' => OrderStatus::Pending,
            'payment_status' => $this->payment_method === 'cod' ? PaymentStatus::Pending : PaymentStatus::Pending,
            'payment_method' => PaymentMethod::from($this->payment_method),
            'shipping_address' => $shippingAddress,
            'coupon_code' => $this->cart->coupon_code,
        ]);

        // Create order items
        foreach ($this->cart->items as $item) {
            $unitPrice = $item->variant
                ? $item->variant->effective_price
                : $item->product->effective_price;

            $order->items()->create([
                'product_id' => $item->product_id,
                'product_variant_id' => $item->product_variant_id,
                'product_name' => $item->product->name,
                'variant_name' => $item->variant?->name,
                'quantity' => $item->quantity,
                'unit_price' => $unitPrice,
                'total' => $unitPrice * $item->quantity,
            ]);
        }

        // Update coupon usage
        if ($this->cart->coupon_code) {
            $coupon = Coupon::where('code', $this->cart->coupon_code)->first();
            if ($coupon) {
                $coupon->increment('used_count');
                $coupon->usages()->create([
                    'user_id' => auth()->id(),
                    'order_id' => $order->id,
                ]);
            }
        }

        // Clear cart
        $this->cart->items()->delete();
        $this->cart->delete();

        $this->dispatch('cart-updated');

        session()->flash('order_success', $order->order_number);

        $this->redirect(route('order.success', $order));
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}
