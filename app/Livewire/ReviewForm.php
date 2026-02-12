<?php

namespace App\Livewire;

use App\Models\OrderItem;
use App\Models\Review;
use Livewire\Component;

class ReviewForm extends Component
{
    public int $productId;

    public int $rating = 0;

    public string $comment = '';

    public bool $submitted = false;

    public function submit(): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'), navigate: false);

            return;
        }

        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $this->productId,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'is_approved' => false,
        ]);

        $this->submitted = true;
        $this->reset(['rating', 'comment']);
    }

    public function getCanReviewProperty(): bool
    {
        if (! auth()->check()) {
            return false;
        }

        return OrderItem::whereHas('order', function ($q) {
            $q->where('user_id', auth()->id())
              ->where('status', 'delivered');
        })->where('product_id', $this->productId)->exists();
    }

    public function getHasReviewedProperty(): bool
    {
        if (! auth()->check()) {
            return false;
        }

        return Review::where('user_id', auth()->id())
            ->where('product_id', $this->productId)
            ->exists();
    }

    public function render()
    {
        return view('livewire.review-form');
    }
}
