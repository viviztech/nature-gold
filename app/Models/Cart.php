<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'coupon_code',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getSubtotalAttribute(): float
    {
        return $this->items->sum(function ($item) {
            $price = $item->variant
                ? $item->variant->effective_price
                : $item->product->effective_price;

            return $price * $item->quantity;
        });
    }

    public function getItemCountAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    public static function currentCart(bool $create = false): ?self
    {
        $query = static::with('items.product', 'items.variant');

        if (auth()->check()) {
            $cart = $query->where('user_id', auth()->id())->first();

            if (! $cart && $create) {
                $cart = static::create(['user_id' => auth()->id()]);
            }

            // Merge session cart into user cart on login
            if ($cart && session()->has('cart_session_id')) {
                $sessionCart = static::where('session_id', session('cart_session_id'))->first();
                if ($sessionCart) {
                    foreach ($sessionCart->items as $item) {
                        $existing = $cart->items()
                            ->where('product_id', $item->product_id)
                            ->where('variant_id', $item->variant_id)
                            ->first();

                        if ($existing) {
                            $existing->increment('quantity', $item->quantity);
                        } else {
                            $cart->items()->create($item->only(['product_id', 'variant_id', 'quantity']));
                        }
                    }
                    $sessionCart->items()->delete();
                    $sessionCart->delete();
                    session()->forget('cart_session_id');
                    $cart->load('items.product', 'items.variant');
                }
            }

            return $cart;
        }

        // Guest cart via session
        $sessionId = session('cart_session_id');

        if ($sessionId) {
            $cart = $query->where('session_id', $sessionId)->first();
            if ($cart) {
                return $cart;
            }
        }

        if ($create) {
            $sessionId = session()->getId();
            session(['cart_session_id' => $sessionId]);

            return static::create(['session_id' => $sessionId]);
        }

        return null;
    }
}
