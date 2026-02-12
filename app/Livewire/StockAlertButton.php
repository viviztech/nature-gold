<?php

namespace App\Livewire;

use App\Models\StockAlert;
use Livewire\Component;

class StockAlertButton extends Component
{
    public int $productId;

    public ?int $variantId = null;

    public bool $isSubscribed = false;

    public function mount(int $productId, ?int $variantId = null): void
    {
        $this->productId = $productId;
        $this->variantId = $variantId;

        if (auth()->check()) {
            $this->isSubscribed = StockAlert::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->where('variant_id', $variantId)
                ->whereNull('notified_at')
                ->exists();
        }
    }

    public function toggle(): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'), navigate: false);

            return;
        }

        $existing = StockAlert::where('user_id', auth()->id())
            ->where('product_id', $this->productId)
            ->where('variant_id', $this->variantId)
            ->whereNull('notified_at')
            ->first();

        if ($existing) {
            $existing->delete();
            $this->isSubscribed = false;
        } else {
            StockAlert::create([
                'user_id' => auth()->id(),
                'product_id' => $this->productId,
                'variant_id' => $this->variantId,
            ]);
            $this->isSubscribed = true;
        }
    }

    public function render()
    {
        return view('livewire.stock-alert-button');
    }
}
