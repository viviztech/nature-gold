<?php

namespace App\Livewire;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.dealer')]
class DealerBulkOrder extends Component
{
    public array $items = [];
    public string $notes = '';

    public function mount(): void
    {
        // Pre-load products for the order form
    }

    public function addItem(int $productId, ?int $variantId = null): void
    {
        $key = $productId . '-' . ($variantId ?? 0);

        if (isset($this->items[$key])) {
            return;
        }

        $product = Product::with('variants')->find($productId);
        if (! $product) {
            return;
        }

        $dealer = auth()->user()->dealer;
        $dealerPrice = $dealer->specialPricing()
            ->where('product_id', $productId)
            ->first();

        $variant = $variantId ? $product->variants->find($variantId) : null;
        $regularPrice = $variant ? $variant->effective_price : $product->effective_price;
        $price = $dealerPrice ? $dealerPrice->special_price : $regularPrice;
        $minQty = $dealerPrice ? $dealerPrice->min_quantity : 1;

        $this->items[$key] = [
            'product_id' => $productId,
            'variant_id' => $variantId,
            'product_name' => $product->name,
            'variant_name' => $variant?->name,
            'regular_price' => $regularPrice,
            'dealer_price' => $price,
            'quantity' => max($minQty, 1),
            'min_quantity' => $minQty,
        ];
    }

    public function removeItem(string $key): void
    {
        unset($this->items[$key]);
    }

    public function updateQuantity(string $key, int $quantity): void
    {
        if (! isset($this->items[$key])) {
            return;
        }

        $minQty = $this->items[$key]['min_quantity'];
        $this->items[$key]['quantity'] = max($minQty, $quantity);
    }

    public function getSubtotalProperty(): float
    {
        return collect($this->items)->sum(fn ($item) => $item['dealer_price'] * $item['quantity']);
    }

    public function getTaxProperty(): float
    {
        return round($this->subtotal * 0.05, 2);
    }

    public function getTotalProperty(): float
    {
        return $this->subtotal + $this->tax;
    }

    public function placeOrder(): void
    {
        if (empty($this->items)) {
            session()->flash('error', 'Please add items to your order.');
            return;
        }

        $user = auth()->user();
        $dealer = $user->dealer;

        $defaultAddress = $user->defaultAddress;
        $shippingAddress = $defaultAddress ? [
            'name' => $defaultAddress->name ?? $user->name,
            'phone' => $defaultAddress->phone ?? $user->phone,
            'line1' => $defaultAddress->line1 ?? '',
            'line2' => $defaultAddress->line2 ?? '',
            'city' => $defaultAddress->city ?? '',
            'district' => $dealer->territory ?? '',
            'state' => $defaultAddress->state ?? 'Tamil Nadu',
            'pincode' => $defaultAddress->pincode ?? '',
        ] : [
            'name' => $user->name,
            'phone' => $user->phone,
            'line1' => $dealer->business_address ?? '',
            'city' => '',
            'district' => $dealer->territory ?? '',
            'state' => 'Tamil Nadu',
            'pincode' => '',
        ];

        $order = Order::create([
            'user_id' => $user->id,
            'subtotal' => $this->subtotal,
            'discount' => 0,
            'shipping_cost' => 0, // Free shipping for dealers
            'tax' => $this->tax,
            'total' => $this->total,
            'status' => OrderStatus::Pending,
            'payment_status' => PaymentStatus::Pending,
            'payment_method' => PaymentMethod::COD,
            'shipping_address' => $shippingAddress,
            'is_dealer_order' => true,
            'notes' => $this->notes ?: null,
        ]);

        foreach ($this->items as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'product_variant_id' => $item['variant_id'],
                'product_name' => $item['product_name'],
                'variant_name' => $item['variant_name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['dealer_price'],
                'total' => $item['dealer_price'] * $item['quantity'],
            ]);
        }

        $this->items = [];
        $this->notes = '';

        session()->flash('order_success', $order->order_number);
        $this->redirect(route('dealer.orders'));
    }

    public function render()
    {
        $products = Product::where('is_active', true)
            ->with(['primaryImage', 'variants', 'category'])
            ->orderBy('name_en')
            ->get();

        return view('livewire.dealer-bulk-order', compact('products'));
    }
}
