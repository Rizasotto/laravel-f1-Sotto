<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    /**
     * Get the user who owns this cart
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items in this cart
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Add an artwork to the cart
     */
    public function addItem(Artwork $artwork, int $quantity = 1): CartItem
    {
        $cartItem = $this->items()->where('artwork_id', $artwork->id)->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cartItem = $this->items()->create([
                'artwork_id' => $artwork->id,
                'quantity' => $quantity,
            ]);
        }

        return $cartItem;
    }

    /**
     * Get total price of cart
     */
    public function getTotal(): float
    {
        return $this->items->sum(function ($item) {
            return $item->artwork->price * $item->quantity;
        });
    }

    /**
     * Clear the cart
     */
    public function clear(): void
    {
        $this->items()->delete();
    }
}
