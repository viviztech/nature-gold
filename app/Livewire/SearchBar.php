<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class SearchBar extends Component
{
    public string $query = '';

    public function updatedQuery(): void
    {
        // Debounced via wire:model.live.debounce.300ms in the view
    }

    public function search(): void
    {
        if (strlen($this->query) >= 2) {
            $this->redirect(route('shop', ['search' => $this->query]), navigate: true);
        }
    }

    public function render()
    {
        $results = [];

        if (strlen($this->query) >= 2) {
            $results = Product::query()
                ->where('is_active', true)
                ->where(function ($q) {
                    $q->where('name_en', 'like', "%{$this->query}%")
                      ->orWhere('name_ta', 'like', "%{$this->query}%")
                      ->orWhere('sku', 'like', "%{$this->query}%");
                })
                ->limit(6)
                ->get();
        }

        return view('livewire.search-bar', compact('results'));
    }
}
