<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'artwork_id', 'quantity'];

    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Get the cart this item belongs to
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the artwork for this cart item
     */
    public function artwork(): BelongsTo
    {
        return $this->belongsTo(Artwork::class);
    }

    /**
     * Get the subtotal for this item
     */
    public function getSubtotalAttribute(): float
    {
        return $this->artwork->price * $this->quantity;
    }
}
